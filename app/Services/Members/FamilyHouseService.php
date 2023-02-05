<?php

namespace App\Services\Members;

use App\Models\FamilyHouse;
use Illuminate\Database\Eloquent\Collection;

class FamilyHouseService
{
    /**
     * create a new family house
     *
     * @param string $house_name
     * @param string $house_leader
     * @return FamilyHouse
     */
    public function createFamilyHouse(string $house_name, string $house_leader): FamilyHouse
    {
        $familyHouse = FamilyHouse::create([
            "house_name" => $house_name,
            "house_leader" => $house_leader
        ]);

        return $familyHouse;
    }

    /**
     * list all family House information
     *
     * @return Collection
     */
    public function listFamilyHouses(): Collection
    {
        $familyHouses = FamilyHouse::all(["id", "house_name", "house_leader", "status"]);

        return $familyHouses;
    }

    /**
     * update family house
     *
     * @param integer $id
     * @param string $family_name
     * @param string $family_leader
     * @param string $status
     * @return FamilyHouse
     */
    public function updateFamilyHouses(int $id, string $house_name, string $house_leader, string $status)
    {
        $updateFamilyHouses = FamilyHouse::where("id", $id)->update([
            "house_name" => $house_name,
            "house_leader" => $house_leader,
            "status" => $status
        ]);

        return $updateFamilyHouses;
    }
}
