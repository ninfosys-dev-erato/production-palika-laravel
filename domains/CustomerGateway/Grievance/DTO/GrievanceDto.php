<?php

namespace Domains\CustomerGateway\Grievance\DTO;

use Illuminate\Support\Facades\Auth;
use Src\Grievance\Enums\GrievanceMediumEnum;
use Src\Grievance\Models\GrievanceType;

class GrievanceDto
{
    public function __construct(
        public readonly ?int $grievance_detail_id,
        public readonly ?int $grievance_type_id,
        public readonly int|array $branch_id,
        public readonly string $subject,
        public readonly string $description,
        public readonly bool $is_public,
        public readonly bool $is_anonymous,
        public readonly bool $is_ward,
        public ?array $files,
        public ?GrievanceMediumEnum $grievance_medium,
    ) {}

    public static function fromValidatedRequest(array $request): GrievanceDto
    {
        $is_ward = GrievanceType::where('id', $request['grievance_type_id'])->first()->is_ward;

        if (Auth::guard('customer')->check()) {
            $grievance_medium = GrievanceMediumEnum::WEB;
        } elseif (Auth::guard('api-customer')->check()) {
            $grievance_medium = GrievanceMediumEnum::MOBILE;
        } elseif (Auth::guard('web')->check()) {
            $grievance_medium = GrievanceMediumEnum::SYSTEM;
        } else {
            $grievance_medium = GrievanceMediumEnum::GUEST;
        }
        return new self(
            grievance_detail_id: $request['grievance_detail_id'] ?? null,
            grievance_type_id: $request['grievance_type_id'],
            branch_id: $request['branch_id'],
            subject: $request['subject'],
            description: $request['description'],
            is_public: $request['is_public'],
            is_anonymous: $request['is_anonymous'],
            is_ward: $is_ward,
            files: $request['files']?? null,
            grievance_medium: $grievance_medium
        );
    }
}