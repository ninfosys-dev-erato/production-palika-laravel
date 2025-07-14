<?php

namespace Domains\CustomerGateway\CustomerDetail\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Customers\Enums\GenderEnum;

class StoreCustomerDetailRequest extends FormRequest
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
            'name' => ['required','string','max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:tbl_customers','email'],
            'is_active' => ['boolean'],
            'avatar' => ['nullable','image', 'mimes:jpg,png,jpeg','max:2048'],
            'gender' => ['required', Rule::in(GenderEnum::cases())],
            'kyc_verified_at' => ['nullable','date']
        ];
    }
}
