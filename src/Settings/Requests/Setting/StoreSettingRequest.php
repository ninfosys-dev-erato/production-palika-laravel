<?php

namespace Src\Settings\Requests\Setting;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class StoreSettingRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'fiscal_year_id' => ['nullable', Rule::exists('mst_fiscal_years', 'id')->withoutTrashed()],
            'office_name' => ['nullable', 'string'],
            'office_name_en' => ['nullable', 'string'],
            'office_address' => ['nullable', 'string'],
            'office_address_en' => ['nullable', 'string'],
            'office_phone' => ['nullable', 'string'],
            'office_phone_en' => ['nullable', 'string'],
            'office_email' => ['required', 'email'],
            'province_id' => ['nullable', Rule::exists('add_provinces', 'id')->withoutTrashed()],
            'district_id' => ['nullable', Rule::exists('add_districts', 'id')->withoutTrashed()],
            'local_body_id' => ['nullable', Rule::exists('add_local_bodies', 'id')->withoutTrashed()],
            'ward'=> ['nullable'],
            'logo' => ['nullable', File::image()->max(2 * 1024)],
            'flag' => ['nullable', File::image()->max(2 * 1024)],
        ];
    }
}
