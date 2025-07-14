<?php

namespace Src\Grievance\DTO;

use Illuminate\Support\Facades\Auth;
use Src\Grievance\Enums\GrievanceMediumEnum;
use Src\Grievance\Enums\GrievancePriorityEnum;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceDetail;

class GrievanceDetailAdminDto
{
    public function __construct(
        public string $token,
        public ?int $grievance_detail_id,
        public int $grievance_type_id,
        public ?int $assigned_user_id,
        public ?int $customer_id,
        public ?int $branch_id,
        public string $subject,
        public string $description,
        public GrievanceStatusEnum $status,
        public ?string $approved_at,
        public bool $is_public,
        public GrievanceMediumEnum $grievance_medium,
        public bool $is_anonymous,
        public ?string $suggestions,
        public string|array $documents,
        public ?GrievancePriorityEnum $priority,
    ){}

    public static function fromLiveWireModel($grievanceDetail, ?array $documents):GrievanceDetailAdminDto{
        return new self(
            token: $grievanceDetail->token,
            grievance_detail_id: $grievanceDetail->grievance_detail_id,
            grievance_type_id: $grievanceDetail->grievance_type_id,
            assigned_user_id: $grievanceDetail->assigned_user_id ?? Auth::guard('web')->id(),
            customer_id: $grievanceDetail->customer_id ?? null,
            branch_id: $grievanceDetail->branch_id,
            subject: $grievanceDetail->subject,
            description: $grievanceDetail->description,
            status: $grievanceDetail->status,
            approved_at: $grievanceDetail->approved_at,
            is_public: $grievanceDetail->is_public,
            grievance_medium: $grievanceDetail->grievance_medium,
            is_anonymous: $grievanceDetail->is_anonymous,
            suggestions: $grievanceDetail->suggestions ?? null,
            documents: $grievanceDetail->documents ?? [],
            priority: $grievanceDetail->priority ?? null,
        );
    }

}
