<?php

namespace App\Http\Requests;

use App\Rules\MobileNumberIdentifierRule;
use App\Traits\HelperDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterCustomerRequest extends FormRequest
{
    use HelperDate;
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('mobile_no')) {
            $this->merge([
                'mobile_no' => $this->convertNepaliToEnglish($this->input('mobile_no')),
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', Rule::unique('tbl_customers', 'email')],
            'mobile_no' => ['required', 'numeric', 'digits:10', 'unique:tbl_customers,mobile_no', new MobileNumberIdentifierRule()],
            'avatar' => ['nullable', 'image', 'mimes:jpg,png,jpeg,gif', 'max:10240'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
