<?php

namespace App\Http\Requests\Savings;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class UpdateShareSavingsRequest extends FormRequest
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
            "number_of_shares" => "required|integer",
            "total_shares_amount" => "required|integer",
            "status" => "required|string",
            "user_id" => "required|integer",
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
