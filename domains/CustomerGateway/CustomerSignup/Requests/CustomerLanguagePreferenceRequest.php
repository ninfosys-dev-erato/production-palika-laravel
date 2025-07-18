<?php

namespace Domains\CustomerGateway\CustomerSignup\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Customers\Enums\LanguagePreferenceEnum;

class CustomerLanguagePreferenceRequest extends FormRequest
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
           'language_preference' => ['required', Rule::in(LanguagePreferenceEnum::cases())]
        ];
    }    
}