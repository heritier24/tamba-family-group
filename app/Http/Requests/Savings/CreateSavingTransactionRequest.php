<?php

namespace App\Http\Requests\Savings;

use Illuminate\Foundation\Http\FormRequest;

class CreateSavingTransactionRequest extends FormRequest
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
            "family_share_saving_id" => "required|integer",
            "monthly_transaction" => "required|string",
            "amount_tobe_paid" => "required|integer",
            "amount_paid" => "required|integer",
            "remaining_amount" => "required|integer",
            "status" => "required|string",
            "user_id" => "required|integer",
            "transaction_to" => "required|string",
        ];
    }
}
