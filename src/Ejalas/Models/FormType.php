<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Settings\Models\Form;

class FormType extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_form_types';

    protected $fillable = [
        'name',
        'form_id',
        'status',
        'form_type',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'name' => 'string',
            'form_id' => 'string',
            'status' => 'boolean',
            'form_type' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This FormTemplate has been {$eventName}");
    }
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
