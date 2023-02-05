<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\Members\CreateFamilyHouseRequest;
use App\Http\Requests\Members\UpdateFamilyHouseRequest;
use App\Services\Members\FamilyHouseService;
use Illuminate\Http\Request;

class FamilyHousesController extends Controller
{
    public function __construct(protected FamilyHouseService $service)
    {
    }
    public function createFamilyHouse(CreateFamilyHouseRequest $request)
    {
        try {
            $this->service->createFamilyHouse($request->house_name, $request->house_leader);

            return response()->json(["family house name created successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function listFamilyHouses()
    {
        try {
            $result = $this->service->listFamilyHouses();

            return response()->json($result);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function updateFamilyHouses(UpdateFamilyHouseRequest $request, int $id)
    {
        try {

            $this->service->updateFamilyHouses($id, $request->house_name, $request->house_leader, $request->status);

            return response()->json(["Family House updated successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }
}
