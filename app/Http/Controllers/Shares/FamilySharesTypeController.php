<?php

namespace App\Http\Controllers\Shares;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shares\CreateSharesTypeRequest;
use App\Http\Requests\Shares\UpdateSharesTypeRequest;
use App\Services\Shares\FamilySharesTypeService;
use Illuminate\Http\Request;

class FamilySharesTypeController extends Controller
{
    public function __construct(protected FamilySharesTypeService $service)
    {
    }

    public function recordSharesType(CreateSharesTypeRequest $request)
    {
        try {

            $this->service->recordSharesType($request->share_type, $request->year, $request->amount);

            return response()->json(["Family share type created successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function listSharetypes()
    {
        try {
            $response = $this->service->listSharesType();

            return response()->json($response);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function updateSharesType(UpdateSharesTypeRequest $request, $id)
    {
        try {
            $this->service->updateSharesType($id, $request->share_type, $request->year, $request->amount);

            return response()->json(["Family share type updated successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function deleteShareType(int $id)
    {
        $this->service->deleteSharesType($id);

        return response()->json(["Family share type deleted successfully"]);
    }
}
