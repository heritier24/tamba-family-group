<?php

namespace App\Http\Requests\Shares;

use Illuminate\Foundation\Http\FormRequest;

class CreateShareContributionRequest extends FormRequest
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
            "share_type_id" => "required|integer",
            "house_member_id" => "required|integer",
            "share_amount" => "required|string",
            "amount_paid" => "required|string",
            "status" => "required|string",
        ];
    }
}
