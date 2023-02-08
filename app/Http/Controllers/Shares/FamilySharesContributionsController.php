<?php

namespace App\Http\Controllers\Shares;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shares\CreateShareContributionRequest;
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
                $request->amount_paid,
                $request->status
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

    public function updateFamilySharesContributions(int $id)
    {
        try {
            $this->service->updateFamilySharesContributions();

            return response()->json(["Family share contribution data updated successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }
}
