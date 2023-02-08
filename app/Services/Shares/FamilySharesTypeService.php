<?php

namespace App\Services\Shares;

use App\Models\FamilyShareType;
use Illuminate\Database\Eloquent\Collection;

class FamilySharesTypeService
{
    /**
     * record share type service
     *
     * @param string $shareType
     * @param string $year
     * @param string $amount
     * @return FamilyShareType
     */
    public function recordSharesType(string $shareType, string $year, string $amount): FamilyShareType
    {
        $shareType = FamilyShareType::create([
            "share_type" => $shareType,
            "year" => $year,
            "amount" => $amount
        ]);

        return $shareType;
    }

    /**
     * Family share type service list
     *
     * @return Collection
     */
    public function listSharesType(): Collection
    {
        $listShareTypes = FamilyShareType::all(["id", "share_type", "year", "amount", "status"]);

        return $listShareTypes;
    }

    /**
     * update share type service
     *
     * @param integer $id
     * @param string $shareType
     * @param string $year
     * @param string $amount
     * @return FamilyShareType
     */
    public function updateSharesType(int $id, string $shareType, string $year, string $amount)
    {
        $updateSharetypes = FamilyShareType::where("id", $id)->update([
            "share_type" => $shareType,
            "year" => $year,
            "amount" => $amount
        ]);

        return $updateSharetypes;
    }

    /**
     * Delete share type service
     *
     * @param integer $id
     * @return void
     */
    public function deleteSharesType(int $id)
    {
        $shareType = FamilyShareType::find($id);

        $shareType->delete();
    }
}
