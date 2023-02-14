<?php

namespace App\Services\Shares;

use App\Exceptions\ItemNotFoundException;
use App\Models\Account;
use App\Models\FamilyHouseMembers;
use App\Models\FamilyShareContribution;
use App\Models\FamilyShareType;
use App\Models\GeneralTransactions;
use Exception;
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
        string $amountPaid
    ) {
        $this->validateShareTypeId($shareTypeID);

        $this->validateHouseMemberID($houseMemberID);

        $createContribution = DB::transaction(function () use ($shareTypeID, $houseMemberID, $shareAmount, $amountPaid) {

            FamilyShareContribution::create([
                "share_type_id" => $shareTypeID,
                "house_member_id" => $houseMemberID,
                "share_amount" => $shareAmount,
                "amount_paid" => $amountPaid,
                "status" => "Unpaid",
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

    public function updateFamilySharesContributions(int $contributionID, string $amountPaid, string $status, $userID, $transactionTo)
    {
        $updateCotributions = DB::transaction(function () use ($contributionID, $amountPaid, $status, $userID, $transactionTo) {
            FamilyShareContribution::where("id", $contributionID)->update([
                "amount_paid" => $amountPaid,
                "status" => $status,
                "user_id" => $userID
            ]);
            $transactionType = $this->findTransactionTypeToCreateTransaction($contributionID);

            $transactionFrom = $this->findTransactionFromToCreateTransaction($contributionID);

            GeneralTransactions::create([
                "transaction_date" => now(),
                "transaction_type" => $transactionType,
                "transaction_from" => $transactionFrom,
                "transaction_to" => $transactionTo,
                "transaction_amount" => $amountPaid,
                "user_id" => $userID
            ]);
            $account = Account::where("account_type", $transactionTo)->first();
            if (!$account) {
                Account::create([
                    "account_type" => $transactionTo,
                    "account_amount" => $amountPaid,
                ]);
            } else {
                $accountId = $account->id;
                $amount = $account->account_amount;
                $accountAmount = $amount + $amountPaid;
                Account::where("id", $accountId)->update([
                    "account_amount" => $accountAmount
                ]);
            }
        });

        return $updateCotributions;
    }

    private function findTransactionTypeToCreateTransaction(int $contributionID): string
    {
        $contribution = DB::selectOne("SELECT family_share_types.share_type
                                       FROM family_share_contributions 
                                       INNER JOIN family_share_types 
                                       ON family_share_contributions.share_type_id = family_share_types.id
                                       WHERE family_share_contributions.id = ?", [$contributionID]);

        if (!$contribution) {
            throw new Exception("Transaction type not found");
        }

        return $contribution->share_type;
    }

    private function findTransactionFromToCreateTransaction(int $contributionID): string
    {
        $transactionFrom = DB::selectOne("SELECT family_members.names
                                          FROM family_share_contributions
                                          INNER JOIN family_house_members
                                          ON family_share_contributions.house_member_id = family_house_members.id
                                          INNER JOIN family_members
                                          ON family_house_members.member_id = family_members.id");

        return $transactionFrom->names;
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
