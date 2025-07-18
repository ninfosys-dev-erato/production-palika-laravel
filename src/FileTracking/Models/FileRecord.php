<?php

namespace Src\FileTracking\Models;

use App\Models\User;
use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Src\Employees\Models\Branch;
use Src\FileTracking\Enums\PatracharStatus;
use Src\FileTracking\Enums\SenderMediumEnum;
use Src\FileTracking\Service\PatracharService;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;

class FileRecord extends Model
{
    use HasFactory, HelperDate;

    protected $table = 'tbl_file_records';

    protected $fillable = [
        'reg_no',
        'title',
        'body',
        'main_thread_id',
        'applicant_name',
        'applicant_address',
        'applicant_mobile_no',
        'status',
        'patrachar_status', //forwarded , Farsyaut , archived,read,unread
        'is_farsyaut',
        'is_chalani',
        'file',
        'subject_type',
        'subject_id',
        'sender_type',
        'sender_id',
        'fiscal_year',
        'ward',
        'recipient_type',
        'recipient_id',
        'farsyaut_id',
        'farsyaut_type',
        'recipient_department',
        'recipient_address',
        'recipient_name',
        'recipient_position',
        'signee_department',
        'signee_name',
        'signee_position',
        'local_body_id',
        'document_level',
        'departments',
        'sender_medium',
        'sender_document_number',
        'registration_date',
        'received_date',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'branch_id'
    ];

    public function casts(): array
    {
        return [
            'reg_no' => 'string',
            'main_thread_id' => 'integer',
            'subject_type' => 'string',
            'body' => 'string',
            'title' => 'string',
            'applicant_name' => 'string',
            'applicant_address' => 'string',
            'applicant_mobile_no' => 'string',
            'recipient_department' => 'string',
            'recipient_name' => 'string',
            'recipient_position' => 'string',
            'recipient_address' => 'string',
            'signee_department' => 'string',
            'recipient_type' => 'string',
            'recipient_id' => 'string',
            'signee_name' => 'string',
            'signee_position' => 'string',
            'patrachar_status' => PatracharStatus::class,
            'is_farsyaut' => 'boolean',
            'is_chalani' => 'boolean',
            'status' => 'string',
            'file' => 'string',
            'subject_id' => 'string',
            'sender_type' => 'string',
            'farsyaut_id' => 'string',
            'farsyaut_type' => 'string',
            'sender_id' => 'string',
            'fiscal_year' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'registration_date' => 'string',
            'received_date' => 'string',
            'deleted_by' => 'string',
            'ward' => 'string',
            'local_body_id' => 'integer',
            'departments' => 'string',
            'document_level' => 'string',
            'sender_document_number' => 'string',
            'sender_medium' => SenderMediumEnum::class,
            'branch_id' => 'integer',
        ];
    }

    public function departments()
    {
        return $this->belongsToMany(Branch::class, 'tbl_files_departments', 'file_id', 'department_id');
    }

    public function recipients()
    {
        $recipients = [];

        $recipientTypes = is_array($this->recipient_type)
            ? $this->recipient_type
            : explode(',', $this->recipient_type);

        $recipientIds = is_array($this->recipient_id)
            ? $this->recipient_id
            : explode(',', $this->recipient_id);

        foreach ($recipientTypes as $index => $type) {
            if (isset($recipientIds[$index]) && class_exists($type)) {
                $recipients[] = $type::find($recipientIds[$index]);
            }
        }

        return collect($recipients)->filter();
    }


    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public function sender(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }
    public function seenFavourites()
    {
        return $this->hasOne(SeenFavourite::class,);
    }

    public function logs()
    {
        return $this->hasMany(FileRecordLog::class, 'reg_id');
    }

    public function mainThreadLogs()
    {
        return $this->hasMany(FileRecordLog::class, 'reg_id', 'main_thread_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year', 'id');
    }
    public function getCreatedAtBsAttribute()
    {
        return $this->adToBs($this->created_at->format('Y-m-d'));
        // return $this->created_at->format('Y-m-d');
    }

    public function recipient(): MorphTo
    {
        return $this->morphTo();
    }
    public function farsyaut(): MorphTo
    {
        return $this->morphTo();
    }
}
