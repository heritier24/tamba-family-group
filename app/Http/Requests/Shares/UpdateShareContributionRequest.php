<?php

namespace App\Http\Requests\Shares;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShareContributionRequest extends FormRequest
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
            "amount_paid" => "required|string",
            "status" => "required|string",
            "user_id" => "required|integer",
            "transaction_to" => "required|string",
        ];
    }
}
