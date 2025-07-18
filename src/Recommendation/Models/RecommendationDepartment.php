<?php

namespace Src\Recommendation\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RecommendationDepartment extends Model
{
    use LogsActivity;
    protected $table = "rec_recommendations_departments";

    protected $fillable = ['branch_id', 'recommendation_id'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
