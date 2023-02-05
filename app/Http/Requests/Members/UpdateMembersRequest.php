<?php

namespace App\Http\Requests\Members;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateMembersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "names" => "string",
            "gender" => "string",
            "phonenumber" => "string",
            "marital_status" => "string",
            "national_id" => "nullable|integer",
            "person_id" => "nullable|integer",
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        if ($validator->fails()) {
            throw new HttpResponseException(response()
                ->json(
                    [
                        "errors" => $validator->errors()->all()
                    ],
                    Response::HTTP_UNPROCESSABLE_ENTITY
                ));
        }
    }
}
