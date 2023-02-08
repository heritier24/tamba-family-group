<?php

namespace App\Services\Shares;

use App\Exceptions\ItemNotFoundException;
use App\Models\FamilyHouseMembers;
use App\Models\FamilyShareContribution;
use App\Models\FamilyShareType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FamilySharesContributionsService
{
    /**
     * recording family shares contribution of the family members
     *
     * @param integer $shareTypeID
     * @param integer $houseMemberID
     * @param string $shareAmount
     * @param string $amountPaid
     * @param string $status
     * @return void
     */
    public function createFamilySharesContributions(
        int $shareTypeID,
        int $houseMemberID,
        string $shareAmount,
        string $amountPaid,
        string $status
    ) {
        $this->validateShareTypeId($shareTypeID);

        $this->validateHouseMemberID($houseMemberID);

        $createContribution = DB::transaction(function () use ($shareTypeID, $houseMemberID, $shareAmount, $amountPaid, $status) {

            FamilyShareContribution::create([
                "share_type_id" => $shareTypeID,
                "house_member_id" => $houseMemberID,
                "share_amount" => $shareAmount,
                "amount_paid" => $amountPaid,
                "status" => $status,
                "user_id" => 1
            ]);
        });

        return $createContribution;
    }

    public function listFamilySharesContributions()
    {
        $familyContributions = DB::select("SELECT family_share_contributions.id, 
                                           family_members.names, 
                                           family_members.gender, 
                                           family_members.phonenumber, 
                                           family_houses.house_name, 
                                           family_share_contributions.share_amount, 
                                           family_share_contributions.amount_paid, 
                                           family_share_contributions.status 
                                           FROM family_share_contributions 
                                           INNER JOIN family_share_types 
                                           ON family_share_contributions.share_type_id = family_share_types.id 
                                           INNER JOIN family_house_members 
                                           ON family_share_contributions.house_member_id = family_house_members.id 
                                           INNER JOIN family_members 
                                           ON family_house_members.member_id = family_members.id 
                                           INNER JOIN family_houses 
                                           ON family_house_members.house_id = family_houses.id");

        return $familyContributions;
    }

    public function updateFamilySharesContributions()
    {
    }

    private function validateShareTypeId(int $shareTypeID)
    {
        $shareType = FamilyShareType::find($shareTypeID);

        if (is_null($shareType)) {
            throw new ItemNotFoundException("Share type not found");
        }
    }

    private function validateHouseMemberID(int $houseID)
    {
        $houseMember = FamilyHouseMembers::find($houseID);

        if (is_null($houseMember)) {
            throw new ItemNotFoundException("Family House Member Not found ");
        }
    }
}
