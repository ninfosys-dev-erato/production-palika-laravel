<?php

namespace Src\TokenTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TokenFeedback extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tok_token_feedbacks';
    protected $primaryKey = 'token_id';
    protected $fillable = [
        'token_id',
        'feedback',
        'rating',
        'service_quality',
        'service_accesibility',
        'citizen_satisfaction',
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
            'token_id' => 'string',
            'feedback' => 'string',
            'rating' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'service_quality' => 'string',
            'service_accesibility' => 'string',
            'citizen_satisfaction' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This TokenFeedback has been {$eventName}");
    }
    public function token()
    {
        return $this->belongsTo(RegisterToken::class, 'token_id', 'id');
    }
}
