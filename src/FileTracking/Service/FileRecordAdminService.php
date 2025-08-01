<?php

namespace Src\FileTracking\Service;

use App\Facades\GlobalFacade;
use App\Traits\SessionFlash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Src\FileTracking\DTO\FileRecordAdminDto;
use Src\FileTracking\Models\FileDepartment;
use Src\FileTracking\Models\FileRecord;

class FileRecordAdminService
{
    use SessionFlash;
    public function store($fileRecordAdminDto)
    {
        $departmentValue = GlobalFacade::department();
        DB::beginTransaction();
        try {
            $file = FileRecord::updateOrCreate(
                [
                    'subject_type' => $fileRecordAdminDto->subject_type,
                    'subject_id' => $fileRecordAdminDto->subject_id
                ],
                [
                    'title' => $fileRecordAdminDto->title,
                    'applicant_name' => $fileRecordAdminDto->applicant_name,
                    'applicant_mobile_no' => $fileRecordAdminDto->applicant_mobile_no,
                    'created_at' => now(),
                    'ward' => $fileRecordAdminDto->ward,
                    'local_body_id' => $fileRecordAdminDto->local_body_id ?? key(getSettingWithKey('palika-local-body')),
                    'document_level' => $fileRecordAdminDto->document_level,
                    'recipient_name' => $fileRecordAdminDto->recipient_name,
                    'recipient_position' => $fileRecordAdminDto->recipient_position,
                    'recipient_department' => $fileRecordAdminDto->recipient_department,
                    'signee_name' => $fileRecordAdminDto->signee_name,
                    'signee_position' => $fileRecordAdminDto->signee_position,
                    'signee_department' => $fileRecordAdminDto->signee_department,
                    'sender_medium' => $fileRecordAdminDto->sender_medium,
                    'is_chalani' => $fileRecordAdminDto->is_chalani ?? false,
                    'applicant_address' => $fileRecordAdminDto->applicant_address ?? null,
                    'patrachar_status' => $fileRecordAdminDto->patrachar_status,
                    'recipient_type' => $fileRecordAdminDto->recipient_type ?? null,
                    'recipient_id' => $fileRecordAdminDto->recipient_id ?? null,
                    'body' => $fileRecordAdminDto->body,
                    'file' => $fileRecordAdminDto->file,
                    'farsyaut_type' => $fileRecordAdminDto->farsyaut_type ?? null,
                    'farsyaut_id' => is_numeric($fileRecordAdminDto->farsyaut_id) ? (int)$fileRecordAdminDto->farsyaut_id : null,
                    'fiscal_year' => $fileRecordAdminDto->fiscal_year ?? key(getSettingWithKey('fiscal-year')),
                    'created_by' => Auth::id(),
                    'branch_id' => $departmentValue ? $departmentValue : null,
                    'registration_date' => $fileRecordAdminDto->registration_date ?? null,
                    'received_date' => $fileRecordAdminDto->received_date ?? null
                ]
            );

            if ($file->subject_type == FileRecord::class) {
                $file->update(['subject_id' => $file->id]);
                if (!empty($fileRecordAdminDto->departments) && $fileRecordAdminDto->departments !== "NULL") {
                    $departments = json_decode($fileRecordAdminDto->departments);

                    if (is_array($departments)) {
                        foreach ($departments as $id) {
                            FileDepartment::updateOrCreate(
                                [
                                    'file_id' => $file->id,
                                    'department_id' => $id,
                                ]
                            );
                        }
                    }
                }
            } else {
                $this->attachDepartments($file->id, $fileRecordAdminDto->departments);
            }

            // If CC is not null, clone the file for each CC recipient
            if ($fileRecordAdminDto && $fileRecordAdminDto->cc && !$fileRecordAdminDto->cc->isEmpty()) {
                foreach ($fileRecordAdminDto->cc->recipients as $recipient) {
                    // Clone the file with updated recipient data
                    FileRecord::create([
                        'subject_type' => $fileRecordAdminDto->subject_type,
                        'subject_id' => $fileRecordAdminDto->subject_id,
                        'main_thread_id' => $file->id, // Link to the main file as the thread
                        'title' => $fileRecordAdminDto->title,
                        'applicant_name' => $fileRecordAdminDto->applicant_name,
                        'applicant_mobile_no' => $fileRecordAdminDto->applicant_mobile_no,
                        'created_at' => now(),
                        'ward' => $fileRecordAdminDto->ward,
                        'local_body_id' => $fileRecordAdminDto->local_body_id ?? key(getSettingWithKey('palika-local-body')),
                        'document_level' => $fileRecordAdminDto->document_level,
                        'recipient_name' => $fileRecordAdminDto->recipient_name,
                        'recipient_position' => $fileRecordAdminDto->recipient_position,
                        'recipient_department' => $fileRecordAdminDto->recipient_department,
                        'signee_name' => $fileRecordAdminDto->signee_name,
                        'signee_position' => $fileRecordAdminDto->signee_position,
                        'signee_department' => $fileRecordAdminDto->signee_department,
                        'sender_medium' => $fileRecordAdminDto->sender_medium,
                        'is_chalani' => $fileRecordAdminDto->is_chalani ?? false,
                        'applicant_address' => $fileRecordAdminDto->applicant_address ?? null,
                        'patrachar_status' => $fileRecordAdminDto->patrachar_status,
                        // Update the recipient information using the CC recipient data
                        'recipient_type' => $recipient->type, // Use CcRecipientDto's type
                        'recipient_id' => $recipient->id, // Use CcRecipientDto's id
                        'body' => $fileRecordAdminDto->body,
                        'file' => $fileRecordAdminDto->file,
                        'farsyaut_type' => $fileRecordAdminDto->farsyaut_type ?? null,
                        'farsyaut_id' => $fileRecordAdminDto->farsyaut_id ?? null,
                        'fiscal_year' => $fileRecordAdminDto->fiscal_year ?? null,
                    ]);
                }
            }


            DB::commit();
            return $file;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    /**
     * Attach multiple departments to the file.
     *
     * @param int $fileId
     * @param string $departmentsJson
     */
    private function attachDepartments($fileId, $departmentsJson)
    {
        $departments = json_decode($departmentsJson, true);

        if ($departments && is_array($departments)) {
            foreach ($departments as $department) {
                $departmentId = $department['id'] ?? null;

                if ($departmentId) {
                    FileDepartment::updateOrCreate(
                        [
                            'file_id' => $fileId,
                            'department_id' => $departmentId,
                        ]
                    );
                }
            }
        }
    }
    public function  updateSender(Model $subject, Authenticatable $sender): FileRecord | \Exception
    {
        $senderClass = get_class($sender);
        $senderId = $sender->id;

        return  FileRecord::updateOrCreate(
            ['subject_type' => $subject->subject_type, 'subject_id' => $subject->subject_id],
            [
                'sender_type' => $senderClass,
                'sender_id' => $senderId
            ]
        );
    }

    public function generateRegNumber(Model $subject, $documentLevel = 'ward', $ward = '0', $localBody = 0, bool $isChalani = false, $department = 0): string
    {
        $class = get_class($subject);
        $id = $subject->id;
        $newRegNo = DB::transaction(function () use ($documentLevel, $ward, $localBody, $isChalani, $department) {
            $fiscalYear = key(getSettingWithKey('fiscal-year'));
            if ($documentLevel === 'ward' && $ward !== 0 && !is_null($ward)) {
                $lastDetail = FileRecord::where('document_level', $documentLevel)
                    ->where('ward', $ward)
                    ->where('is_chalani', $isChalani)
                    ->where('fiscal_year', $fiscalYear)
                    ->whereNotNull('reg_no')
                    ->orderByDesc('id')
                    ->lockForUpdate()
                    ->first();

                $maxRegNo = $lastDetail?->reg_no;
            } else {
                $lastDetail = FileRecord::where('document_level', 'palika')
                    ->whereNotNull('reg_no')
                    ->whereNull('ward')
                    ->where('is_chalani', $isChalani)
                    ->where('fiscal_year', $fiscalYear)
                    ->orderByDesc('id')
                    ->lockForUpdate()
                    ->first();
                $maxRegNo = $lastDetail?->reg_no;
            }

            return $maxRegNo ? intval($maxRegNo) + 1 : 1;
        });

        $record = FileRecord::updateOrCreate(
            ['subject_type' => $class, 'subject_id' => $id],
            [
                'reg_no' => $newRegNo,
                'registration_date' => $subject->registration_date ?? date('Y-m-d H:i:s'),
                'document_level' => $documentLevel
            ]
        );
        return $record->reg_no;
    }

    public function delete(FileRecord $fileRecord)
    {
        return tap($fileRecord)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        FileRecord::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
}
