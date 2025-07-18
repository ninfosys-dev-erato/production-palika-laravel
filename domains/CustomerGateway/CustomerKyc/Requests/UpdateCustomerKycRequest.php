<?php

namespace Domains\CustomerGateway\CustomerKyc\Requests;

use App\Rules\ValidNepaliDate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Customers\Enums\DocumentTypeEnum;
use Src\Customers\Enums\GenderEnum;

class UpdateCustomerKycRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'email' => ['nullable','email', 'max:255', Rule::unique('tbl_customers')->ignore($this->user())],
            'gender' => ['required', Rule::in(GenderEnum::cases())],
            'nepali_date_of_birth' => ['required', 'string', new ValidNepaliDate()],
            'english_date_of_birth' => ['required', 'date', 'before:tomorrow'],
            'grandfather_name' => ['required', 'string', 'max:100'],
            'father_name' => ['required', 'string', 'max:100'],
            'mother_name' => ['required', 'string', 'max:100'],
            'spouse_name' => ['nullable', 'string', 'max:100'],
            'permanent_province_id' => ['required', 'integer', Rule::exists('add_provinces', 'id')],
            'permanent_district_id' => ['required', 'integer', Rule::exists('add_districts', 'id')],
            'permanent_local_body_id' => ['required', 'integer', Rule::exists('add_local_bodies', 'id')],
            'permanent_ward' => ['required', 'string', 'max:100'],
            'permanent_tole' => ['nullable', 'string', 'max:100'],
            'temporary_province_id' => ['required', 'integer', Rule::exists('add_provinces', 'id')],
            'temporary_district_id' => ['required', 'integer', Rule::exists('add_districts', 'id')],
            'temporary_local_body_id' => ['required', 'integer', Rule::exists('add_local_bodies', 'id')],
            'temporary_ward' => ['required', 'string', 'max:100'],
            'temporary_tole' => ['nullable', 'string', 'max:100'],
            'document_type' => ['required', 'string', Rule::in(DocumentTypeEnum::cases())],
            'document_issued_date_nepali' => ['required', 'string', new ValidNepaliDate()],
            'document_issued_date_english' => ['required', 'string', 'date', 'before:tomorrow'],
            'document_issued_at' => ['required', 'integer', Rule::exists('add_districts', 'id')],
            'document_number' => ['required', 'string', 'max:50'],
            'document_image1' => ['nullable', 'string'],
            'document_image2' => ['nullable', 'string'],
            'expiry_date_nepali' => ['nullable', 'string', 'after:document_issued_date_nepali'],
            'expiry_date_english' => ['nullable', 'date', 'after:document_issued_date_english'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('The name field is required.'),
            'email.email' => __('Please provide a valid email address.'),
            'email.max' => __('The email must not exceed 255 characters.'),
            'email.unique' => __('This email is already in use.'),
            'gender.required' => __('Gender is required.'),
            'gender.in' => __('The selected gender is invalid.'),
            'nepali_date_of_birth.required' => __('Nepali date of birth is required.'),
            'english_date_of_birth.required' => __('English date of birth is required.'),
            'english_date_of_birth.before' => __('The date of birth must be before tomorrow.'),
            'grandfather_name.required' => __('The grandfather\'s name is required.'),
            'grandfather_name.max' => __('The grandfather\'s name must not exceed 100 characters.'),
            'father_name.required' => __('The father\'s name is required.'),
            'father_name.max' => __('The father\'s name must not exceed 100 characters.'),
            'mother_name.required' => __('The mother\'s name is required.'),
            'mother_name.max' => __('The mother\'s name must not exceed 100 characters.'),
            'spouse_name.max' => __('The spouse\'s name must not exceed 100 characters.'),
            'permanent_province_id.required' => __('The permanent province ID is required.'),
            'permanent_province_id.exists' => __('The selected permanent province is invalid.'),
            'permanent_district_id.required' => __('The permanent district ID is required.'),
            'permanent_district_id.exists' => __('The selected permanent district is invalid.'),
            'permanent_local_body_id.required' => __('The permanent local body ID is required.'),
            'permanent_local_body_id.exists' => __('The selected permanent local body is invalid.'),
            'permanent_ward.required' => __('The permanent ward is required.'),
            'permanent_ward.max' => __('The permanent ward must not exceed 100 characters.'),
            'permanent_tole.max' => __('The permanent tole must not exceed 100 characters.'),
            'temporary_province_id.required' => __('The temporary province ID is required.'),
            'temporary_province_id.exists' => __('The selected temporary province is invalid.'),
            'temporary_district_id.required' => __('The temporary district ID is required.'),
            'temporary_district_id.exists' => __('The selected temporary district is invalid.'),
            'temporary_local_body_id.required' => __('The temporary local body ID is required.'),
            'temporary_local_body_id.exists' => __('The selected temporary local body is invalid.'),
            'temporary_ward.required' => __('The temporary ward is required.'),
            'temporary_ward.max' => __('The temporary ward must not exceed 100 characters.'),
            'temporary_tole.max' => __('The temporary tole must not exceed 100 characters.'),
            'document_type.required' => __('The document type is required.'),
            'document_type.in' => __('The selected document type is invalid.'),
            'document_issued_date_nepali.required' => __('The Nepali document issued date is required.'),
            'document_issued_date_english.required' => __('The English document issued date is required.'),
            'document_issued_date_english.before' => __('The document issued date must be before tomorrow.'),
            'document_issued_at.required' => __('The document issued at is required.'),
            'document_issued_at.exists' => __('The selected document issued at is invalid.'),
            'document_number.required' => __('The document number is required.'),
            'document_number.max' => __('The document number must not exceed 50 characters.'),
            'document_image1.required' => __('Document image 1 is required.'),
            'document_image2.required' => __('Document image 2 is required.'),
            'expiry_date_nepali.after' => __('The expiry date in Nepali must be after the issued date.'),
            'expiry_date_english.after' => __('The expiry date in English must be after the issued date.'),
        ];
    }   

}
