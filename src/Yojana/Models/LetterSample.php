<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Enums\LetterTypes;

class LetterSample extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_letter_samples';

    protected $fillable = [
        'letter_type',
        'implementation_method_id',
        'name',
        'subject',
        'styles',
        'sample_letter',
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
            'letter_type' => LetterTypes::class,
            'implementation_method_id' => 'string',
            'name' => 'string',
            'subject' => 'string',
            'sample_letter' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This LetterSample has been {$eventName}");
    }

    public function implementationMethod(): BelongsTo
    {
        return $this->belongsTo(ImplementationMethod::class);
    }
    public function letterType()
    {
        return $this->belongsTo(LetterType::class, 'letter_type', 'id');
    }
}
