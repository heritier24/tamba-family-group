<?php

namespace App\Http\Controllers\Shares;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shares\CreateShareContributionRequest;
use App\Http\Requests\Shares\UpdateShareContributionRequest;
use App\Services\Shares\FamilySharesContributionsService;
use Illuminate\Http\Request;

class FamilySharesContributionsController extends Controller
{
    public function __construct(protected FamilySharesContributionsService $service)
    {
    }
    /**
     * Undocumented function
     *
     * @param CreateShareContributionRequest $request
     * @return void
     */
    public function createFamilySharesContributions(CreateShareContributionRequest $request)
    {
        try {
            $this->service->createFamilySharesContributions(
                $request->share_type_id,
                $request->house_member_id,
                $request->share_amount,
                $request->amount_paid
            );

            return response()->json(["family share contribution saved"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function listFamilySharesContributions()
    {
        try {
            $result = $this->service->listFamilySharesContributions();

            return response()->json($result);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    /**
     * update share contribution send request data to service
     *
     * @param UpdateShareContributionRequest $request
     * @param integer $contributionID
     * @throws Exception
     */
    public function updateFamilySharesContributions(UpdateShareContributionRequest $request, int $contributionID)
    {
        try {
            $this->service->updateFamilySharesContributions($contributionID, $request->amount_paid, $request->status, $request->user_id, $request->transaction_to);

            return response()->json(["Family share contribution data updated successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }
}
