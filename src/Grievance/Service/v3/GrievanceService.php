<?php

namespace Src\Grievance\Service\v3;

use Domains\CustomerGateway\Grievance\DTO\GrievanceDto;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Src\Grievance\Enums\GrievancePriorityEnum;
use Src\Grievance\Enums\GrievanceStatusEnum;
use Src\Grievance\Models\GrievanceDetail;

class GrievanceService
{

    protected $path;

    public function __construct()
    {
        $this->path = config('src.Grievance.grievance.path');
    }

    public function create(GrievanceDto $grievanceDto, $customer)
    {

        $grievance = GrievanceDetail::create([
            'token' => strtoupper(Str::random(7)),
            'grievance_type_id' => $grievanceDto->grievance_type_id,
            'grievance_detail_id' => $grievanceDto->grievance_detail_id,
            'customer_id' => $customer->id ?? null,
            'subject' => $grievanceDto->subject,
            'description' => $grievanceDto->description,
            'status' => GrievanceStatusEnum::UNSEEN,
            'is_public' => $grievanceDto->is_public,
            'is_anonymous' => $grievanceDto->is_anonymous,
            'priority' => GrievancePriorityEnum::LOW,
            'local_body_id' => $customer->kyc->permanent_local_body_id ?? null,
            'ward_id' => $customer->kyc->permanent_ward ?? null,
            'is_visible_to_public' => true,
            'is_ward' => $grievanceDto->is_ward,
            'grievance_medium' => $grievanceDto->grievance_medium,
            'documents' => $grievanceDto->files ?? []  // ← FIXED: Store files in documents column
        ]);

        $grievance->branches()->sync($grievanceDto->branch_id);
        
        // REMOVED: No longer creating separate GrievanceFile records
        // if (!empty($grievanceDto->files)) {
        //     GrievanceFile::create([
        //         'grievance_detail_id' => $grievance->id,
        //         'file_name' => $grievanceDto->files,
        //     ]);
        // }

        $locale = App::getLocale();
        $message = $locale === 'ne'
            ? __('complaint_registered', ['token' => $grievance->token])
            : 'Congratulations! Your complaint has been registered with complaint number ' . $grievance->token . '. We will follow-up on your complaint and contact you.';

        return [
            'message' => $message,
            'grievanceToken' => $grievance->token,
        ];
    }
}
