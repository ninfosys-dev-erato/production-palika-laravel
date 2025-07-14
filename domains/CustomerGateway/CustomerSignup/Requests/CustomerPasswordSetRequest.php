<?php

namespace Domains\CustomerGateway\CustomerSignup\Requests;

use App\Rules\PasswordStrengthRule;
use App\Traits\HelperDate;
use Illuminate\Foundation\Http\FormRequest;

class CustomerPasswordSetRequest extends FormRequest
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
            'mobile_no' => 'required',
            'password' => ['required', 'confirmed', new PasswordStrengthRule()],
            'expo_push_token' => ['nullable', 'string'],
            'notification_preference' => ['nullable', 'string']
        ];
    }    
}