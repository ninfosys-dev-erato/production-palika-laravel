<?php

namespace Src\Settings\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Settings\Enums\TemplateEnum;

class LetterHeadSample extends Model
{
    use LogsActivity;

    protected $table = 'mst_letter_head_samples';

    protected $fillable = [
        'name',
        'slug',
        'content',
        'style',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];

    protected $casts = [
        'name' => 'string',
        'slug' => TemplateEnum::class,
        'content' => 'string',
        'style' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'deleted_at' => 'datetime',
    ];


    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
