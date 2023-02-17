<?php

namespace App\Services\Savings;

use App\Models\FamilyShareSavings;
use Exception;
use Illuminate\Support\Facades\DB;

class FamilyShareSavingsService
{
    public function listSavingsShare()
    {
        $shares = DB::select("SELECT
                                   family_share_savings.id,
                                   family_members.names AS familyNames,
                                   family_share_types.share_type AS savingType,
                                   family_share_savings.saving_amount AS savingAmount,
                                   family_share_savings.number_of_shares AS sharesNumber,
                                   family_share_savings.total_shares_amount AS totalSharesAmount,
                                   family_share_savings.status AS status,
                                   users.name AS recordedBy
                               FROM family_share_savings
                                   INNER JOIN family_share_types ON family_share_savings.share_type_id = family_share_types.id
                                   INNER JOIN family_house_members ON family_share_savings.house_member_id = family_house_members.id
                                   INNER JOIN family_houses ON family_house_members.house_id = family_houses.id
                                   INNER JOIN family_members ON family_house_members.member_id = family_members.id
                                   INNER JOIN users ON family_share_savings.user_id = users.id");

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
        $transactions = DB::select("SELECT
                                        family_members.names AS members,
                                        family_share_types.share_type AS savingType,
                                        family_share_saving_transactions.amount_tobe_paid AS amountTobePaid,
                                        family_share_saving_transactions.amount_paid AS transactionAmount,
                                        family_share_saving_transactions.remaining_amount AS remainingAmount,
                                        family_share_saving_transactions.status AS status,
                                        users.name AS recordedBy
                                    FROM
                                        family_share_saving_transactions
                                        INNER JOIN family_share_savings ON family_share_saving_transactions.family_share_saving_id = family_share_savings.id
                                        INNER JOIN family_share_types ON family_share_savings.share_type_id = family_share_types.id
                                        INNER JOIN family_house_members ON family_share_savings.house_member_id = family_house_members.id
                                        INNER JOIN family_members ON family_house_members.member_id = family_members.id
                                        INNER JOIN users ON family_share_saving_transactions.user_id = users.id");

        return $transactions;
    }
}
