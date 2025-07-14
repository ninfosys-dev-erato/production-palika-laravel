<?php

namespace Src\Yojana\DTO;


use Src\Yojana\Models\CostEstimation;

class CostEstimationAdminDto
{
    public function __construct(
        public ?string $plan_id,
        public ?string $date,
        public ?string $total_cost,
        public ?string $is_revised,
        public ?string $revision_no,
        public ?string $revision_date,
        public ?string $status,
        public ?string $document_upload,
        public ?string $rate_analysis_document,
        public ?string $cost_estimation_document,
        public ?string $initial_photo,
    ){}

    public static function fromLiveWireModel(CostEstimation $costEstimation):CostEstimationAdminDto{
        return new self(
                plan_id : $costEstimation->plan_id,
                date : $costEstimation->date,
                total_cost : $costEstimation->total_cost,
                is_revised : $costEstimation->is_revised,
                revision_no : $costEstimation->revision_no,
                revision_date : $costEstimation->revision_date,
                status : $costEstimation->status,
                document_upload : $costEstimation->document_upload,
                rate_analysis_document: $costEstimation -> rate_analysis_document,
                cost_estimation_document: $costEstimation -> cost_estimation_document,
                initial_photo: $costEstimation -> initial_photo
        );
    }
}
