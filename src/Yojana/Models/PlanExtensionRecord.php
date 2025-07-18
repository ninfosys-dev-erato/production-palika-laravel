<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;


class PlanExtensionRecord extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_plan_extension_records';

    protected $fillable = [
'plan_id',
'extension_date',
'previous_extension_date',
'previous_completion_date',
'letter_submission_date',
'letter',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'plan_id' => 'string',
    'extension_date' => 'string',
    'previous_extension_date' => 'string',
    'previous_completion_date' => 'string',
    'letter_submission_date' => 'string',
    'letter' => 'string',
    'id' => 'int',
    'created_at' => 'datetime',
    'created_by' => 'string',
    'updated_at' => 'datetime',
    'updated_by' => 'string',
    'deleted_at' => 'datetime',
    'deleted_by' => 'string',
];
    }

    public function getActivitylogOptions(): LogOptions
    {
         return LogOptions::defaults()
                ->logFillable()
                ->logOnlyDirty()
                ->setDescriptionForEvent(fn(string $eventName) => "This PlanExtensionRecord has been {$eventName}");
     }

//    public function getPreviousExtensionDateAttribute()
//    {
//        return self::where('plan_id', $this->plan_id)
//            ->where('id', '<', $this->id)
//            ->whereNull('deleted_at')
//            ->orderByDesc('id')
//            ->value('extension_date');
//    }

    public function getPreviousExtensionDateAttribute()
    {
        // If current record is not saved yet, there's no previous extension
        if (!$this->id || !$this->plan_id) {
            return null;
        }

        return self::where('plan_id', $this->plan_id)
            ->where('id', '<', $this->id)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->value('extension_date');
    }

    public function getPreviousSubmissionDateAttribute()
    {
        return self::where('plan_id', $this->plan_id)
            ->where('id', '<', $this->id)
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->value('letter_submission_date');
    }

}
