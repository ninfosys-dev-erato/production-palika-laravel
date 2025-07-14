<?php

namespace Src\Recommendation\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ApplyRecommendationDocument extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;

    protected $table = 'rec_apply_recommendation_documents';
    protected $fillable = [
        'apply_recommendation_id',
        'title',
        'document',
        'status',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $casts = [
        'apply_recommendation_id' => 'integer',
        'title' => 'string',
        'document' => 'string',
        'status' => RecommendationStatusEnum::class,
        'remarks' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    public function applyRecommendation(): BelongsTo
    {
        return $this->belongsTo(ApplyRecommendation::class, 'apply_recommendation_id');
    }

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