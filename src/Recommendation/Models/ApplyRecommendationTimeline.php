<?php

namespace Src\Recommendation\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class ApplyRecommendationTimeline extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'rec_apply_recommendation_timelines';
    protected $fillable = [
        'apply_recommendation_id',
        'status_old',
        'status_new',
        'data_old',
        'data_new',
        'remarks',
        'updated_by',
    ];
    protected $casts = [
        'apply_recommendation_id' => 'integer',
        'status_old' => RecommendationStatusEnum::class,
        'status_new' => RecommendationStatusEnum::class,
        'data_old' => 'json',
        'data_new' => 'json',
        'remarks' => 'string',
        'updated_by' => 'integer',
    ];

    public function applyRecommendation(): BelongsTo
    {
        return $this->belongsTo(ApplyRecommendationTimeline::class, 'apply_recommendation_id');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
}
}