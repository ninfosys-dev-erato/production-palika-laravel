<?php

namespace Src\FileTracking\DTO;

use App\Facades\GlobalFacade;
use Illuminate\Database\Eloquent\Model;
use Src\FileTracking\Enums\PatracharStatus;
use Src\FileTracking\Enums\SenderMediumEnum;
use Src\FileTracking\Models\FileRecord;
use Src\Wards\Models\Ward;

class FileRecordAdminDto
{
    public function __construct(
        public string $title,
        public ?string $recipient_address = "N/A",
        public ?string $applicant_name,
        public ?string $applicant_mobile_no,
        public ?string $subject_type,
        public ?string $subject_id,
        public ?string $ward,
        public ?string $local_body_id,
        public ?string $departments,
        public ?string $document_level,
        public ?string $recipient_name,
        public ?string $recipient_position,
        public ?string $recipient_department,
        public ?string $signee_department,
        public ?string $signee_position,
        public ?string $signee_name,
        public ?bool $is_chalani,
        public ?string $sender_medium,
        public ?string $applicant_address,
        public ?PatracharStatus $patrachar_status,
        public null|array|string $recipient_type,
        public null|array|string $recipient_id,
        public ?string $body,
        public ?string $fiscal_year,
        public ?string $file,
        public ?string $farsyaut_type,
        public int|string|null $farsyaut_id,
        public ?string $sender_document_number,
        public ?string $registration_date,
        public ?string $received_date = null,
        public ?CcCollectionDto $cc = null,
    ) {}

    public static function fromLiveWireModel(FileRecord $fileRecord): FileRecordAdminDto
    {
        return new self(
            subject_type: $fileRecord->subject_type,
            subject_id: $fileRecord->subject_id,
            ward: $fileRecord->ward,
            local_body_id: $fileRecord->local_body_id,
            departments: $fileRecord->departments,
            applicant_name: $fileRecord->applicant_name,
            applicant_mobile_no: $fileRecord->applicant_mobile_no,
            applicant_address: $fileRecord->applicant_address,
            document_level: $fileRecord->document_level,
            body: $fileRecord->body,
        );
    }

    public static function fromServiceSession(Model $subjectModel)
    {
        $departments = null;
        $class = get_class($subjectModel);
        $id = $subjectModel->id;
        $ward = GlobalFacade::ward();
        $local_body_id = $subjectModel->local_body_id;
        $title = "";
        $applicant_name = "";
        $applicant_mobile_no = "";
        $applicant_address = "";
        $document_level = $subjectModel->is_ward ? 'ward' : 'palika';
        $sender_document_number= null;
        $registration_date= null;
        $received_date= null;
        switch ($class) {
            case "Src\Grievance\Models\GrievanceDetail":
                $title = $subjectModel->subject;
                $subjectModel = $subjectModel->load('customer');
                $applicant_name = $subjectModel->customer->name ?? 'Anonymous User';
                $applicant_mobile_no = $subjectModel->customer->mobile_no ?? 'N/A';
                $departments =  $subjectModel->grievanceType?->departments;
                $departmentSelected =  $subjectModel?->branches;
                if ($document_level === 'ward') {
                    $ward = $subjectModel->ward_id ?? GlobalFacade::ward();
                } else {
                    $ward = null;
                }
                $local_body_id = $subjectModel->local_body_id;
                $fiscal_year = $subjectModel->fiscal_year_id ?? key(getSettingWithKey('fiscal-year'));
                $cc = collect();
                if ($subjectModel->is_ward && $subjectModel->ward) {
                    $cc->push(CcRecipientDto::fromModel($subjectModel->ward));
                }
                if (!empty($departments)) {
                    $departmentsDto = $departments->map(fn($department) => CcRecipientDto::fromModel($department));
                    $cc = $cc->merge($departmentsDto);
                }
                if (!empty($departmentSelected)) {
                    $departmentsDto = $departmentSelected->map(fn($department) => CcRecipientDto::fromModel($department));
                    $cc = $cc->merge($departmentsDto);
                }
                $cc = $cc->isNotEmpty() ? CcCollectionDto::fromCcCollection($cc) : null;
                break;

            case "Src\Recommendation\Models\ApplyRecommendation":

                $recommendation = $subjectModel->load('recommendation.departments', 'customer.kyc.permanentLocalBody');
                $signeeType = $subjectModel->signee_type;
                $signeeId = $subjectModel->signee_id;
                if ($signeeType && $signeeId) {
                    $signee = $signeeType::find($signeeId);
                    if ($signee instanceof \App\Models\User) {
                        $signeeName = $signee->name;
                    } elseif ($signee instanceof \Src\Recommendation\Models\RecommendationSigneesUser) {
                        $signeeName = optional($signee->user)->name ?? '';
                    } else {
                        $signeeName = '';
                    }
                } else {
                    $signeeName = '';
                }
                $title = $recommendation->recommendation->title;
                $subjectModel = $subjectModel->load('customer');
                $applicant_name = $subjectModel->customer->name;
                $applicant_mobile_no = $subjectModel->customer->mobile_no;
                $applicant_address = $subjectModel->customer->kyc->permanentLocalBody->title . ' - ' . replaceNumbers($subjectModel->customer->kyc->permanent_ward, true);
                $recipient_name = $applicant_name;
                $recipient_address = $applicant_address;
                $departments =  $subjectModel->recommendation->branches;
                $signee_name =  $signeeName;
                if ($document_level === 'ward') {
                    $ward = $subjectModel->ward_id ?? GlobalFacade::ward();
                } else {
                    $ward = null;
                }
                $local_body_id = $subjectModel->local_body_id;
                $fiscal_year = $subjectModel->fiscal_year_id ?? key(getSettingWithKey('fiscal-year'));
                $is_chalani = true;
                $cc = collect(); // Initialize the $cc collection

                // Handle the case for the ward
                if ($subjectModel->is_ward && $subjectModel->ward_id) {
                    $wardModel = Ward::find($subjectModel->ward_id);
                    if ($wardModel) {
                        $cc->push(CcRecipientDto::fromModel($wardModel));
                    }
                    $recipient_type = Ward::class;
                    $recipient_id = $subjectModel->ward_id;
                }

                if (!empty($departments)) {
                    $departmentsDto = $departments->map(fn($department) => CcRecipientDto::fromModel($department));
                    // Merge the departments into the $cc collection
                    $cc = $cc->merge($departmentsDto);
                }
                $cc = $cc->isNotEmpty() ? CcCollectionDto::fromCcCollection($cc) : null;

                break;

            case "Src\BusinessRegistration\Models\BusinessRegistration":
                $registration = $subjectModel->load('registrationType');
                $title = $registration->registrationType->title;
                $subjectModel = $subjectModel->load('ward');
                $applicant_name = $subjectModel->applicant_name;
                $applicant_mobile_no = $subjectModel->applicant_number;
                $departments = null;
                $ward = GlobalFacade::ward() ?? null;
                $document_level = GlobalFacade::ward() ? 'ward' : 'palika';
                $local_body_id = $subjectModel->local_body_id;
                $fiscal_year = $subjectModel->fiscal_year_id ?? key(getSettingWithKey('fiscal-year'));
                $recipient_type = 'Src\Wards\Models\Ward';
                $recipient_id = $subjectModel->ward_no;
                $registration_date = $subjectModel->application_date_en ?? null;

                break;

            case "Src\FileTracking\Models\FileRecord":
                $title = $subjectModel->title;
                $recipient_address = $subjectModel->recipient_address ?? "N/A";
                $applicant_name = $subjectModel->applicant_name ?? null;
                $applicant_mobile_no = $subjectModel->applicant_mobile_no ?? null;
                $applicant_address = $subjectModel->applicant_address ?? null;
                $departments = $subjectModel->departments ?? null;
                if ($subjectModel->document_level === 'ward') {
                    $ward = $subjectModel->ward_id ?? GlobalFacade::ward();
                } else {
                    $ward = null;
                }
                $local_body_id = $subjectModel->local_body_id ?? null;
                $document_level = $subjectModel->document_level;
                $recipient_name = $subjectModel->recipient_name ?? null;
                $recipient_department = $subjectModel->recipient_department ?? null;
                $recipient_position = $subjectModel->recipient_position ?? null;
                $signee_name = $subjectModel->signee_name ?? null;
                $signee_department = $subjectModel->signee_department ?? null;
                $signee_position = $subjectModel->signee_position ?? null;
                $is_chalani = $subjectModel->is_chalani ?? null;
                $sender_medium = $subjectModel->sender_medium ?? null;
                $recipient_type = $subjectModel->recipient_type ?? null;
                $recipient_id = $subjectModel->recipient_id ?? null;
                $body = $subjectModel->body ?? null;
                $fiscal_year = $subjectModel->fiscal_year;
                $file = $subjectModel->file ?? null;
                $farsyaut_type = $subjectModel->farsyaut_type ?? null;
                $farsyaut_id = $subjectModel->farsyaut_id ?? null;
                $sender_document_number = $subjectModel->sender_document_number ?? null;
                $registration_date = $subjectModel->registration_date ?? null;
                $received_date = $subjectModel->received_date ?? null;

                break;

            case "Src\Ejalas\Models\ComplaintRegistration":
                $complainant = $subjectModel->parties->first();
                $title = $subjectModel->subject;
                $subjectModel = $subjectModel->load('parties');
                $applicant_name = $complainant->name ?? 'Complainer';
                $applicant_mobile_no = $subjectModel->phone_no ?? 'N/A';
                $departments =  null;
                $local_body_id = $subjectModel->local_body_id;
                    $recipient_type = 'Src\Wards\Models\Ward';
                    $recipient_id = $complainant->permanent_ward_id ?? GlobalFacade::ward();
                break;
        }

        return new self(
            title: $title,
            applicant_name: $applicant_name,
            applicant_mobile_no: $applicant_mobile_no,
            subject_type: $class,
            subject_id: $id,
            ward: $ward,
            local_body_id: $local_body_id,
            departments: $departments,
            document_level: $document_level,
            recipient_name: $recipient_name ?? null,
            recipient_position: $recipient_position ?? null,
            recipient_department: $recipient_department ?? null,
            signee_department: $signee_department ?? null,
            signee_position: $signee_position ?? null,
            signee_name: $signee_name ?? null,
            is_chalani: $is_chalani ?? false,
            sender_medium: $sender_medium ?? SenderMediumEnum::THROUGH_PERSONAL->value,
            applicant_address: $applicant_address,
            patrachar_status: PatracharStatus::PENDING,
            recipient_type: $recipient_type ?? null,
            recipient_id: $recipient_id ?? null,
            body: $body ?? null,
            file: $file ?? null,
            fiscal_year: $fiscal_year ?? key(getSettingWithKey('fiscal-year')),
            farsyaut_type: $farsyaut_type ?? null,
            farsyaut_id: (!empty($farsyaut_id) && is_numeric($farsyaut_id)) ? (int)$farsyaut_id : null,
            sender_document_number: $sender_document_number??null,
            registration_date: $registration_date??null,
            received_date: $received_date??null,
            cc: $cc ?? null,
            recipient_address: $recipient_address ?? null,
        );
    }
}
