<?php

namespace Domains\CustomerGateway\Recommendation\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Src\Recommendation\Enums\RecommendationStatusEnum;

class ApplyRecommendationRequest extends FormRequest
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
            'recommendation_id' => ['required', 'integer', Rule::exists('rec_recommendations', 'id')],
            'data' => ['required', 'array'],
            'status' => ['nullable',  Rule::in(RecommendationStatusEnum::cases())],
            'remarks' => ['nullable', 'string'],

            'documents' => ['nullable', 'array'],
            'documents.*.title' => ['required_with:documents', 'string', 'max:255'],
            'documents.*.document' => ['required_with:documents', 'string'],
            'documents.*.status' => ['nullable', Rule::in(RecommendationStatusEnum::cases())],
            'documents.*.remarks' => ['nullable', 'string'],
            'is_ward' => ['nullable', 'boolean'],

        ];
    }
    public function messages(): array
    {
        return [
            'recommendation_id.required' => __('Recommendation ID is required.'),
            'recommendation_id.exists' => __('Recommendation not found.'),
            'data.required' => __('Form data is required.'),

            'documents.*.title.required_with' => __('Document title is required when uploading documents.'),
            'documents.*.document.required_with' => __('Document file is required when uploading documents.'),
        ];
    }
    
}
