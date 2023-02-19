<?php

namespace App\Http\Controllers\Shares\Savings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Savings\CreateSavingTransactionRequest;
use App\Http\Requests\Savings\CreateShareSavingsRequest;
use App\Http\Requests\Savings\UpdateShareSavingsRequest;
use App\Services\Savings\FamilyShareSavingsService;

class FamilySharesSavingsController extends Controller
{
    public function __construct(protected FamilyShareSavingsService $service)
    {
    }
    public function listSavingsShare()
    {
        try {
            $result = $this->service->listSavingsShare();

            return response()->json($result);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function recordSavings(CreateShareSavingsRequest $request)
    {
        try {
            $this->service->recordSavings(
                $request->share_type_id,
                $request->house_member_id,
                $request->saving_amount,
                $request->number_of_shares,
                $request->total_shares_amount,
                $request->user_id
            );

            return response()->json(["Record Savings Share Created successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function updateSavings(UpdateShareSavingsRequest $request, int $savingID)
    {
        try {
            $this->service->updateSavings(
                $savingID,
                $request->number_of_shares,
                $request->total_shares_amount,
                $request->status,
                $request->user_id
            );

            return response()->json(["Share Savings Updated Successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function createSavingsTransactions(CreateSavingTransactionRequest $request)
    {
        try {
            $this->service->createSavingsTransactions(
                $request->family_share_saving_id,
                $request->monthly_transaction,
                $request->amount_tobe_paid,
                $request->amount_paid,
                $request->remaining_amount,
                $request->status,
                $request->user_id,
                $request->transaction_to
            );

            return response()->json(["Share Savings transactions Created Successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function listSavingsTransactions()
    {
        try {
            $result = $this->service->listSavingsTransactions();

            return response()->json($result);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }
}
