<?php

namespace App\Services\Savings;

use App\Models\FamilyShareSavings;
use Exception;

class FamilyShareSavingsService
{
    public function listSavingsShare()
    {
        $shares = FamilyShareSavings::all(["*"]);

        return $shares;
    }

    public function recordSavings(
        int $shareTypeID,
        int $houseMemberID,
        string $savingAmount,
        int $numberOfShare,
        int $totalShareAmount,
        int $userID
    ) {
        $totalSharesAmount = $totalShareAmount;
        if ($totalSharesAmount !== $totalShareAmount) {
            throw new Exception("Total share amount is not matching with total shares");
        } else {
            $savings = FamilyShareSavings::create([
                "share_type_id" => $shareTypeID,
                "house_member_id" => $houseMemberID,
                "saving_amount" => $savingAmount,
                "number_of_shares" => $numberOfShare,
                "total_shares_amount" => $totalSharesAmount,
                "status" => "active",
                "user_id" => $userID
            ]);
        }

        return $savings;
    }

    public function updateSavings(int $savingID, int $numberOfShare, int $totalShareAmount, string $status, int $userID)
    {
        $saving = FamilyShareSavings::where("id", $savingID)->first();
        if ($saving) {
            $savingAmount = $saving->saving_amount;
            $totalSaving = $savingAmount * $numberOfShare;
            if ($totalSaving != $totalShareAmount) {
                throw new Exception("Invalid total saving amount: $totalShareAmount depends on total saving amount to be: $totalSaving please enter a valid amount");
            }
        } else {
            throw new Exception("Family saving not found ! Please Create a new one ");
        }
        $updateSavings = FamilyShareSavings::where("id", $savingID)->update([
            "number_of_shares" => $numberOfShare,
            "total_shares_amount" => $totalSaving,
            "status" => $status,
            "user_id" => $userID
        ]);

        return $updateSavings;
    }

    public function savingsTransactions()
    {
    }
}
