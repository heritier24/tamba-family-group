<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Http\Requests\Members\CreateMembersRequest;
use App\Http\Requests\Members\UpdateMembersRequest;
use App\Services\Members\FamilyMembersService;
use Illuminate\Http\Request;

class FamilyMembersController extends Controller
{
    public function __construct(protected FamilyMembersService $service)
    {
    }
    public function create(CreateMembersRequest $request)
    {
        try {

            $this->service->create(
                $request->names,
                $request->gender,
                $request->phonenumber,
                $request->marital_status,
                $request->national_id,
                $request->person_id
            );

            return response()->json(["Family Member created successfully"]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function listMembers()
    {
        try {

            $response = $this->service->listMembers();

            return response()->json($response);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }

    public function updateMembers(UpdateMembersRequest $request, int $id)
    {
        try {

            $this->service->updateMembers($id, $request->names, $request->gender, $request->phonenumber, $request->marital_status, $request->national_id, $request->person_id);

            return response()->json([
                "Family Members Updated Success"
            ]);
        } catch (\Exception $e) {
            [$message, $statusCode, $exceptionCode] = getHttpMessageAndStatusCodeFromException($e);

            return response()->json([
                "message" => $message,
            ], $statusCode);
        }
    }
}
