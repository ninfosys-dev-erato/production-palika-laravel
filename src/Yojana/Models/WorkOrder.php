<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class WorkOrder extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'pln_work_order';

    protected $fillable = [
        'date',
        'plan_id',
        'plan_name',
        'subject',
        'letter_body',
        'template',
        'letter_sample_id',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'template',
    ];

    public function casts(): array
    {
        return [
            'date' => 'string',
            'plan_id' => 'string',
            'plan_name' => 'string',
            'subject' => 'string',
            'letter_body' => 'string',
            'letter_sample_id' => 'int',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'template' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This WorkOrder has been {$eventName}");
    }

    public function letter_sample()
    {
        return $this->belongsTo(LetterSample::class, 'letter_sample_id', 'id');
    }

}
