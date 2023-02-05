<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\Members\CreateFamilyHouseMembersRequest;
use App\Services\Members\FamilyHouseMemberService;
use Illuminate\Http\Request;

class FamilyHouseMembersController extends Controller
{
    public function __construct(protected FamilyHouseMemberService $service)
    {
    }
    public function createFamilyHouseMembers(CreateFamilyHouseMembersRequest $request)
    {
        try {
            $this->service->createFamilyHouseMembers($request->house_id, $request->member_id);

            return response()->json(["Successfully added family members to house"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function listFamilyHouseMembers()
    {
        try {

            $result = $this->service->listFamilyHouseMembers();

            return response()->json($result);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }
}
