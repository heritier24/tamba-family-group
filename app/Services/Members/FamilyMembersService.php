<?php

namespace App\Services\Members;

use App\Models\FamilyMembers;
use Illuminate\Database\Eloquent\Collection;

class FamilyMembersService
{
    /**
     * create a new family members
     *
     * @param string $names
     * @param string $gender
     * @param string $phonenumber
     * @param string $marital_status
     * @param integer|null $national_id
     * @param integer|null $person_id
     * @return void
     */
    public function create(
        string $names,
        string $gender,
        string $phonenumber,
        string $marital_status,
        ?string $national_id,
        ?int $person_id
    ) {
        $members = FamilyMembers::create([
            "names" => $names,
            "gender" => $gender,
            "phonenumber" => $phonenumber,
            "marital_status" => $marital_status,
            "national_id" => $national_id,
            "person_id" => $person_id
        ]);

        return $members;
    }

    /**
     * list family members
     *
     * @return Collection
     */
    public function listMembers(): Collection
    {
        $members = FamilyMembers::all(["id", "names", "gender", "phonenumber", "marital_status", "national_id", "person_id"]);

        return $members;
    }

    public function updateMembers($id, $names, $gender, $phonenumber, $marital_status, $national_id, $person_id): FamilyMembers
    {
        $update = FamilyMembers::where("id", $id)->update([
            "names" => $names,
            "gender" => $gender,
            "phonenumber" => $phonenumber,
            "marital_status" => $marital_status,
            "national_id" => $national_id,
            "person_id" => $person_id
        ]);

        return $update;
    }
}
