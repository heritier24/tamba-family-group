<?php

namespace App\Services\Members;

use App\Models\FamilyHouse;
use App\Models\FamilyHouseMembers;
use App\Models\FamilyMembers;
use Exception;
use Illuminate\Support\Facades\DB;

class FamilyHouseMemberService
{

    /**
     * Add members to a family house
     *
     * @param integer $houseID
     * @param integer $memberID
     * @return void
     */
    public function createFamilyHouseMembers(int $houseID, int $memberID)
    {
        $house = FamilyHouse::find($houseID);
        if (is_null($house)) {
            throw new Exception("House $houseID not found");
        }
        $member = FamilyMembers::find($memberID);
        if (is_null($member)) {
            throw new Exception("Member $memberID not found");
        }

        $houseMember = FamilyHouseMembers::create([
            "house_id" => $houseID,
            "member_id" => $memberID
        ]);

        return $houseMember;
    }

    /**
     * List Family house members
     *
     * @return array
     */
    public function listFamilyHouseMembers(): array
    {
        $familyHousesMembers = DB::select("SELECT family_members.names, 
                                           family_members.gender, 
                                           family_members.phonenumber, 
                                           family_members.marital_status, 
                                           family_houses.house_name, 
                                           family_houses.house_leader 
                                           FROM family_house_members 
                                           INNER JOIN family_members 
                                           ON family_house_members.member_id = family_members.id 
                                           INNER JOIN family_houses 
                                           ON family_house_members.house_id = family_houses.id");

        return $familyHousesMembers;
    }
}
