<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\Installments;
use Src\Yojana\Models\Evaluation;

class EvaluationAdminDto
{
    public function __construct(
        public string $plan_id,
        public string $evaluation_date,
        public string $completion_date,
        public Installments $installment_no,
        public ?string $up_to_date_amount,
        public ?string $assessment_amount,
        public ?int $total_vat,
        public string $evaluation_amount,
        public ?string $is_implemented,
        public ?string $is_budget_utilized,
        public ?string $is_quality_maintained,
        public ?string $is_reached,
        public ?string $is_tested,
        public ?string $testing_date,
        public ?string $attendance_number,
        public ?string $evaluation_no,
        public ?string $ward_recommendation_document,
        public ?string $technical_evaluation_document,
        public ?string $committee_report,
        public ?string $attendance_report,
        public ?string $construction_progress_photo,
        public ?string $work_completion_report,
        public ?string $expense_report,
        public ?string $other_document,
        public ?bool $is_vatable,
    ) {}

    public static function fromLiveWireModel(Evaluation $evaluation): EvaluationAdminDto
    {
        return new self(
            plan_id: $evaluation->plan_id,
            evaluation_date: $evaluation->evaluation_date,
            completion_date: $evaluation->completion_date,
            installment_no: $evaluation->installment_no,
            up_to_date_amount: $evaluation->up_to_date_amount,
            assessment_amount: $evaluation->assessment_amount,
            evaluation_amount: $evaluation->evaluation_amount,
            total_vat: $evaluation->total_vat,
            is_implemented: $evaluation->is_implemented ?? false,
            is_budget_utilized: $evaluation->is_budget_utilized ?? false,
            is_quality_maintained: $evaluation->is_quality_maintained ?? false,
            is_reached: $evaluation->is_reached ?? false,
            is_tested: $evaluation->is_tested ?? false,
            testing_date: $evaluation->testing_date,
            attendance_number: $evaluation->attendance_number,
            evaluation_no: $evaluation->evaluation_no,
            ward_recommendation_document: $evaluation->ward_recommendation_document,
            technical_evaluation_document: $evaluation->technical_evaluation_document,
            committee_report: $evaluation->committee_report,
            attendance_report: $evaluation->attendance_report,
            construction_progress_photo: $evaluation->construction_progress_photo,
            work_completion_report: $evaluation->work_completion_report,
            expense_report: $evaluation->expense_report,
            other_document: $evaluation->other_document,
            is_vatable: $evaluation->is_vatable ?? false
        );
    }
}
