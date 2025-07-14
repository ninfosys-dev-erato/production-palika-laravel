<?php

namespace Domains\CustomerGateway\CustomerSignup\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Customers\Enums\LanguagePreferenceEnum;

class CustomerNotificationPreferenceRequest extends FormRequest
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
            'notification_preference' => ['required', 'array'],
            'notification_preference.mail' => 'boolean',
            'notification_preference.sms' => 'boolean',
            'notification_preference.expo' => 'boolean',
            'expo_push_token' => ['nullable', 'string']
        ];
    }    
}