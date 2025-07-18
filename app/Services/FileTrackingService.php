<?php

namespace App\Services;

use App\Enums\Action;
use App\Models\User;
use App\Facades\GlobalFacade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\FileTracking\DTO\FileRecordAdminDto;
use Src\FileTracking\DTO\FileRecordLogAdminDto;
use Src\FileTracking\DTO\FileRecordNotifieeAdminDto;
use Src\FileTracking\Service\FileRecordAdminService;
use Src\FileTracking\Service\FileRecordLogAdminService;
use Src\FileTracking\Service\FileRecordNotifieeAdminService;
use Src\Recommendation\Services\RecommendationService;

class FileTrackingService
{
    public $_fileRecordService;
    public $_fileRecordLogService;
    public $_fileRecordNotifeeService;
    public $_recommendationService;

    public function __construct()
    {
        $this->_fileRecordService = new FileRecordAdminService();
        $this->_fileRecordLogService = new FileRecordLogAdminService();
        $this->_fileRecordNotifeeService = new FileRecordNotifieeAdminService();
        $this->_recommendationService = new RecommendationService();
    }

    public function recordFile(Model $model, bool $admin = true, $action = null, bool $register = false, $customer = false)
    {
        $class = get_class($model);
        $user = $admin ? Auth::guard('web')->user() : Auth::guard('customer')->user();
        if ($customer) {
            $user = Auth::guard('api-customer')->user();
        }
        $id = $model->id;
        $originalValues = $model->getOriginal();
        $dirtyValues = $model->getDirty();
        switch ($class) {
            case "Src\Grievance\Models\GrievanceDetail":
                $record = $this->_fileRecordService->store(FileRecordAdminDto::fromServiceSession(
                    subjectModel: $model,
                ));

                if (empty($log->reg_no) && $register) {
                    $this->getRegistrationNumber(model: $model);
                    $message = "गुनासो दर्ता गरिएको छ!";
                    $notes = $this->getNotesForGrievance(dirtyValues: $dirtyValues, message: $message);
                } else {
                    $notes =  $this->getNotesForGrievance($dirtyValues);
                }

                $log = $this->_fileRecordLogService->store(FileRecordLogAdminDto::fromServiceSession(
                    handlerModel: $user,
                    notes: $notes,
                    status: $model->status->value,
                    reg_id: $record->id
                ));
                // Pass the log to the method
                $this->getNotesForGrievance($dirtyValues, $log);
                $this->recordSender(model: $record);
                break;
            case "Src\Ejalas\Models\ComplaintRegistration":
                $record = $this->_fileRecordService->store(FileRecordAdminDto::fromServiceSession(
                    subjectModel: $model,
                ));

                if (empty($log->reg_no) && $register) {
                    $this->getRegistrationNumber(model: $model);
                    $message = "उजुरी दर्ता गरिएको छ!";
                } else {
                }


                $log = $this->_fileRecordLogService->store(FileRecordLogAdminDto::fromServiceSession(
                    handlerModel: $user,
                    notes: "",
                    status: $model->status ? __("Approved") : __("Rejected"),
                    reg_id: $record->id
                ));
                $this->recordSender(model: $record);
                break;

            case "Src\Recommendation\Models\ApplyRecommendation":
                $record = $this->_fileRecordService->store(FileRecordAdminDto::fromServiceSession(
                    subjectModel: $model,
                ));

                if (empty($log->reg_no) && $register) {
                    $this->getRegistrationNumber(model: $model);
                    $message = "सिफारिस दर्ता गरिएको छ!";
                    $notes = $this->getNotesForGrievance(dirtyValues: $dirtyValues, message: $message);
                } else {
                    $notes =  $this->getNotesForGrievance($dirtyValues);
                }

                $this->_fileRecordLogService->store(FileRecordLogAdminDto::fromServiceSession(
                    handlerModel: $user,
                    notes: $notes,
                    status: $model->status->value,
                    reg_id: $record->id
                ));
                $this->recordSender(model: $record);
                break;

            case "Src\BusinessRegistration\Models\BusinessRegistration":
                $record = $this->_fileRecordService->store(FileRecordAdminDto::fromServiceSession(
                    subjectModel: $model,
                ));

                if (empty($log->reg_no) && $register) {
                    $model->registration_date = $model->registration_date_en;
                    $this->getRegistrationNumber(model: $model);
                    $message = "सिफारिस दर्ता गरिएको छ!";
                    $notes = $this->getNotesForBusinessRegistration(dirtyValues: $dirtyValues, message: $message);
                } else {
                    $notes =  $this->getNotesForBusinessRegistration($dirtyValues);
                }

                $this->_fileRecordLogService->store(FileRecordLogAdminDto::fromServiceSession(
                    handlerModel: $user,
                    notes: $notes,
                    status: $model->application_status,
                    reg_id: $record->id,
                    admin: $admin
                ));
                $this->recordSender(model: $record);
                break;

            case "Src\FileTracking\Models\FileRecord":
                $record = $this->_fileRecordService->store(FileRecordAdminDto::fromServiceSession(
                    subjectModel: $model,
                ));

                $sender = $this->recordSender(model: $record);

                if ($action == Action::CREATE) {

                    $this->getRegistrationNumber(model: $record);
                }
                break;
        }
    }

    public function recordSender(Model $model)
    {
        $sender = Auth::guard('customer')->user()
            ?? Auth::guard('api-customer')->user()
            ?? Auth::guard('web')->user();

        return $this->_fileRecordService->updateSender(
            subject: $model,
            sender: $sender
        );
    }

    public function getRegistrationNumber(Model $model): string | null
    {
        try {
            $class = get_class($model);

            switch ($class) {
                case "Src\Grievance\Models\GrievanceDetail":
                    $documentLevel = $model->is_ward ? "ward" : "palika";
                    $ward = $model->is_ward ? $model->ward_id : 0;
                    $branch = $model->branch_id ? $model->branch_id : 0;
                    $localBodyId = $model->local_body_id ?? getSettingWithKey('palika-local-body');
                    return $this->_fileRecordService->generateRegNumber(
                        subject: $model,
                        documentLevel: $documentLevel,
                        ward: $ward,
                        localBody: $localBodyId,
                        isChalani: false,
                        department: $branch
                    );
                case "Src\Recommendation\Models\ApplyRecommendation":
                    $documentLevel = $model->is_ward ? "ward" : "palika";
                    $ward = $model->is_ward ? $model->ward_id : 0;
                    $branch = GlobalFacade::department() ?? 0;
                    $localBodyId = $model->local_body_id ?? getSettingWithKey('palika-local-body');
                    $regNumber =  $this->_fileRecordService->generateRegNumber(
                        subject: $model,
                        documentLevel: $documentLevel,
                        ward: $ward,
                        localBody: $localBodyId,
                        isChalani: true,
                        department: $branch
                    );

                    if ($regNumber && $model->additional_letter) {
                        $this->_recommendationService->updateAdditionalLetter($model, $regNumber);
                    }

                    return $regNumber;
                case "Src\FileTracking\Models\FileRecord":
                    $documentLevel = $model->document_level;
                    $ward =  $documentLevel == 'ward' ?  $model->ward : 0;
                    $localBodyId = $model->local_body_id ?? getSettingWithKey('palika-local-body');
                    $isChalani = $model->is_chalani ?? false;
                    $branch = GlobalFacade::department() ?? 0;
                    return $this->_fileRecordService->generateRegNumber(
                        subject: $model,
                        documentLevel: $documentLevel,
                        ward: $ward,
                        localBody: $localBodyId,
                        isChalani: $isChalani,
                        department: $branch
                    );
                case "Src\Ejalas\Models\ComplaintRegistration":
                    $documentLevel = "palika";
                    $ward = 0;
                    $localBodyId = 0;
                    $branch = GlobalFacade::department() ?? 0;
                    return $this->_fileRecordService->generateRegNumber(
                        subject: $model,
                        documentLevel: $documentLevel,
                        ward: $ward,
                        localBody: $localBodyId,
                        isChalani: false,
                        department: $branch
                    );

                case "Src\BusinessRegistration\Models\BusinessRegistration":
                    $documentLevel = GlobalFacade::ward() ? 'ward' : 'palika';
                    $ward =  GlobalFacade::ward() ?? null;
                    $localBodyId = $model->local_body_id ?? getSettingWithKey('palika-local-body');
                    $branch = GlobalFacade::department() ?? 0;

                    return $this->_fileRecordService->generateRegNumber(
                        subject: $model,
                        documentLevel: $documentLevel,
                        ward: $ward,
                        localBody: $localBodyId,
                        isChalani: false,
                        department: $branch
                    );
            }
        } catch (\Exception $e) {
            logger($e);
            DB::rollBack();
        }
        return null;
    }


    private function getNotesForGrievance(array $dirtyValues, $log = null, $message = null): string
    {
        if ($message) {
            $notes = $message;
            return $notes;
        }
        $notes = [];

        foreach ($dirtyValues as $attribute => $value) {
            switch ($attribute) {
                case 'assigned_user_id':
                    $user = User::find($value);
                    $notes[] = "Assigned to {$user->name} ({$user->mobile_no})";

                    if ($log) {
                        $this->_fileRecordNotifeeService->store(FileRecordNotifieeAdminDto::fromServiceSession(
                            file_record_log_id: $log->id,
                            handlerModel: $user
                        ));
                    }
                    break;

                case 'status':
                    $notes[] = "स्थिति {$value} मा परिवर्तन गरिएको छ।";
                    break;
                case 'priority':
                    $notes[] = "प्राथमिकता {$value} मा परिवर्तन गरिएको छ।";
                    break;
                case 'suggestions':
                    $notes[] = "सुझावहरू थपिएको छ।";
                    break;
                case 'documents':
                    $notes[] = "कागजातहरू थपिएको छ।";
            }
        }


        return !empty($notes) ? implode("\n", $notes) : "कुनै परिवर्तन गरिएको छैन।";
    }

    private function getNotesForRecommendation(array $dirtyValues, $log = null, $message = null): string
    {
        if ($message) {
            $notes = $message;
            return $notes;
        }

        $notes = [];
        if (empty($dirtyValues)) {
            return "कुनै परिवर्तन गरिएको छैन।";
        }

        foreach ($dirtyValues as $attribute => $value) {
            switch ($attribute) {

                case 'status':
                    $notes[] = "स्थिति {$value} मा परिवर्तन गरिएको छ।";
                    break;
                case 'bill':
                    $notes[] = "बिल अपलोड गरिएको छ।";
                    break;
                case 'ltax_ebp_code':
                    $notes[] = "LTAX EBP CODE थपिएको छ।";
                    break;
                case 'priority':
                    $notes[] = "प्राथमिकता {$value} मा परिवर्तन गरिएको छ।";
                    break;
                case 'suggestions':
                    $notes[] = "सुझावहरू थपिएका छन्।";
                    break;
                case 'documents':
                    $notes[] = "कागजातहरू थपिएका छन्।";
            }
        }
        return !empty($notes) ? implode("\n", $notes) : "कुनै परिवर्तन गरिएको छैन।";
    }

    private function getNotesForBusinessRegistration(array $dirtyValues, string $message = null): string
    {
        $notes = [];

        if ($message) {
            $notes = $message;
            return $notes;
        }

        if (empty($dirtyValues)) {
            return "कुनै परिवर्तन गरिएको छैन।";
        }

        foreach ($dirtyValues as $attribute => $value) {
            switch ($attribute) {

                case 'application_status':
                    $notes[] = "दर्ता आवेदन {$value} मा परिवर्तन गरिएको छ।";
                    break;
                case 'business_status':
                    $notes[] = "व्यवसाय स्थिति {$value} मा परिवर्तन गरिएको छ।";
                    break;
                case 'bill':
                    $notes[] = "बिल अपलोड गरिएको छ।";
                    break;
            }
        }
        return !empty($notes) ? implode("\n", $notes) : "कुनै परिवर्तन गरिएको छैन।";
    }

    public function setFavourite() {}
}
