<?php

namespace Domains\CustomerGateway\CustomerDetail\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Customers\Enums\GenderEnum;

class UpdateCustomerDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['string','max:100'],
            'mobile_no' => ['string', 'digits:10'],
            'email' => ['email', 'max:255', Rule::unique('tbl_customers')->ignore($this->user())],
            'is_active' => ['boolean'],
            'avatar' => ['nullable','image', 'mimes:jpg,png,jpeg','max:2048'],
            'gender' => ['required', Rule::in(GenderEnum::cases())],
            'kyc_verified_at' => ['nullable','date']
        ];
    }
}
