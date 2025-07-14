<?php

namespace Domains\CustomerGateway\Grievance\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreGrievanceRequest extends FormRequest
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
            'grievance_detail_id' => ['nullable', Rule::exists('gri_grievance_details', 'id')],
            'grievance_type_id' => ['required', Rule::exists('gri_grievance_types', 'id')],
            'branch_id' => ['nullable', Rule::exists('mst_branches', 'id')],
            'subject' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'is_public' => ['boolean'],
            'grievance_medium' => ['nullable', 'string', 'max:255'],
            'is_anonymous' => ['boolean'],
            'files' => ['nullable', 'array'],
            'files.*' => ['nullable', 'string'],
            'is_ward' => ['nullable', 'boolean']
        ];
    }
    public function messages(): array
    {
        return [
            'grievance_detail_id.exists' => __('The selected grievance detail is invalid.'),
            'grievance_type_id.required' => __('The grievance type is required.'),
            'grievance_type_id.exists' => __('The selected grievance type is invalid.'),
            'branch_id.exists' => __('The selected branch is invalid.'),
            'subject.required' => __('The subject field is required.'),
            'subject.string' => __('The subject must be a string.'),
            'subject.max' => __('The subject must not exceed 255 characters.'),
            'description.required' => __('The description field is required.'),
            'description.string' => __('The description must be a string.'),
            'is_public.boolean' => __('The is public field must be true or false.'),
            'is_ward.boolean' => __('The is field must be true or false.'),
            'grievance_medium.string' => __('The grievance medium must be a string.'),
            'grievance_medium.max' => __('The grievance medium must not exceed 255 characters.'),
            'is_anonymous.boolean' => __('The is anonymous field must be true or false.'),
            'files.array' => __('The files must be an array.'),
            'files.*.string' => __('Each file must be a string.'),
        ];
    }
    
}
