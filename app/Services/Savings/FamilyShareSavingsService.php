<?php

namespace App\Services\Savings;

use App\Models\Account;
use App\Models\FamilyShareSavings;
use App\Models\FamilyShareSavingTransaction;
use App\Models\GeneralTransactions;
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

    public function createSavingsTransactions(
        int $familyShareSavingID,
        string $monthlyandYear,
        int $amountTobePaid,
        int $amountPaid,
        int $remainingAmount,
        string $status,
        int $userID,
        string $transactionTo
    ) {
        $createSavingsTransactions = DB::transaction(function () use ($familyShareSavingID, $monthlyandYear, $amountTobePaid, $amountPaid, $remainingAmount, $status, $userID, $transactionTo) {
            $shareMemberSaving = FamilyShareSavings::where("id", $familyShareSavingID)->first();
            if (!$shareMemberSaving) {
                throw new Exception("Family share saving does not exist ! Please record share saving amount ");
            }
            if ($shareMemberSaving->total_shares_amount != $amountTobePaid) {
                throw new Exception("Amount to be paid is not equal to $amountTobePaid it must be $shareMemberSaving->total_shares_amount please record share saving amount to be paid well ");
            }
            $remaining = $shareMemberSaving->total_shares_amount - $amountPaid;
            if ($remaining != $remainingAmount) {
                throw new Exception("Amount Remining must be $remaining not to be $remainingAmount");
            }
            FamilyShareSavingTransaction::create([
                "family_share_saving_id" => $familyShareSavingID,
                "monthly_transaction" => $monthlyandYear,
                "amount_tobe_paid" => $shareMemberSaving->total_shares_amount,
                "amount_paid" => $amountPaid,
                "remaining_amount" => $remaining,
                "status" => $status,
                "user_id" => $userID
            ]);
            $transactionType = $this->findTransactionTypetoCreateTransaction($familyShareSavingID);

            $transactionFrom = $this->getTransactionFrom($familyShareSavingID);

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
        return $createSavingsTransactions;
    }

    public function updateSavingsTransactions(
        int $transactionID,
        string $monthlyandYear,
        int $amountTobePaid,
        int $amountPaid,
        int $remainingAmount,
        int $newUpdatedAmount,
        string $transactionTo,
        int $userID
    ) {
        $updateSavingsTransactions = DB::transaction(function () use ($transactionID, $monthlyandYear, $amountTobePaid, $amountPaid, $remainingAmount, $newUpdatedAmount, $transactionTo, $userID) {
            $transaction = FamilyShareSavingTransaction::where("id", $transactionID)->first();
            if (!$transaction) {
                throw new Exception("Could not find transaction family saving with id $transactionID");
            }
            $transactionPeriod = $transaction->monthly_transaction;
            if ($transactionPeriod != $monthlyandYear) {
                throw new Exception("Monthly and you select is incorrect : it's $transactionPeriod instead of $monthlyandYear");
            }
            $tobePaid = $transaction->amount_tobe_paid;
            if ($tobePaid != $amountTobePaid) {
                throw new Exception("Amount to be paid is $tobePaid instead of $amountTobePaid");
            }
            $paid = $transaction->amount_paid;
            if ($paid != $amountPaid) {
                throw new Exception("Amount to be paid is $paid instead of $amountPaid ");
            }
            $amountPaidUpdate = $newUpdatedAmount + $amountPaid;
            $remainingUpdate = $amountTobePaid - $amountPaidUpdate;
            if ($remainingUpdate != $remainingAmount) {
                throw new Exception("Amount remaining to pay is $remainingUpdate instead of $remainingAmount");
            }

            FamilyShareSavingTransaction::where("id", $transactionID)->update([
                "amount_paid" => $amountPaidUpdate,
                "remaining_amount" => $remainingUpdate
            ]);
            $transactionFrom = $this->getTransactionFromToUpdateSavingstransaction($transactionID);
            GeneralTransactions::create([
                "transaction_date" => now(),
                "transaction_type" => "Savings",
                "transaction_from" => $transactionFrom,
                "transaction_to" => $transactionTo,
                "transaction_amount" => $newUpdatedAmount,
                "user_id" => $userID
            ]);

            $account = Account::where("account_type", $transactionTo)->first();
            if (!$account) {
                Account::create([
                    "account_type" => $transactionTo,
                    "account_amount" => $newUpdatedAmount,
                ]);
            } else {
                $accountId = $account->id;
                $amount = $account->account_amount;
                $accountAmount = $amount + $newUpdatedAmount;
                Account::where("id", $accountId)->update([
                    "account_amount" => $accountAmount
                ]);
            }
        });

        return $updateSavingsTransactions;
    }

    private function getTransactionFromToUpdateSavingstransaction($transactionID)
    {
        $transactionFrom = DB::selectOne("SELECT family_members.names 
                                          FROM family_share_saving_transactions 
                                          INNER JOIN family_share_savings 
                                          ON family_share_saving_transactions.family_share_saving_id = family_share_savings.id
                                          INNER JOIN family_house_members 
                                          ON family_share_savings.house_member_id = family_house_members.id 
                                          INNER JOIN family_members 
                                          ON family_house_members.member_id = family_members.id 
                                          WHERE family_share_saving_transactions.id = ?", [$transactionID]);
        return $transactionFrom->names;
    }

    private function getTransactionFrom(int $familyShareSavingID)
    {
        $memberFrom = DB::selectOne("SELECT family_members.names 
                                     FROM family_share_savings 
                                     INNER JOIN family_house_members 
                                     ON family_share_savings.house_member_id = family_house_members.id 
                                     INNER JOIN family_members ON family_house_members.member_id = family_members.id 
                                     WHERE family_share_savings.id = ?", [$familyShareSavingID]);
        return $memberFrom->names;
    }

    private function findTransactionTypetoCreateTransaction(int $familyShareSavingID)
    {
        $share =  DB::selectOne("SELECT family_share_types.share_type 
                              FROM family_share_savings 
                              INNER JOIN family_share_types 
                              ON family_share_savings.share_type_id = family_share_types.id 
                              WHERE family_share_savings.id = ?", [$familyShareSavingID]);
        if (!$share) {
            throw new Exception("Could not find transaction type for family_share_types");
        }
        return $share->share_type;
    }

    public function listSavingsTransactions()
    {
        $transactions = DB::select("SELECT
                                        family_members.names AS members,
                                        family_share_types.share_type AS savingType,
                                        family_share_saving_transactions.monthly_transaction AS monthlyandYear,
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
