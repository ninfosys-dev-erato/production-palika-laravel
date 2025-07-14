<?php


namespace Src\Recommendation\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RecommendationLog extends Model
{
    use HasFactory, LogsActivity;
    protected $table = 'tbl_recommendation_logs';

    protected $fillable = [
        'apply_recommendation_id',
        'old_status',
        'new_status',
        'old_details',
        'new_details',
        'updated_by',
        'remarks',
    ];

    protected $casts = [
        'apply_recommendation_id' => 'integer',
        'old_status' => 'string',
        'new_status' => 'string',
        'old_details' => 'string',
        'new_details' => 'string',
        'updated_by' => 'string',
        'remarks' => 'string',
    ];

    public function applyRecommendation ()
    {
        return $this->belongsTo(ApplyRecommendation::class, 'apply_recommendation_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

}
