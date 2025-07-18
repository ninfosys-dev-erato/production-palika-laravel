<?php

namespace Src\Recommendation\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RecommendationsRoles extends Model
{
    use LogsActivity;
    protected $table = "tbl_recommendations_roles";

    protected $fillable = [
        'recommendation_id',
        'role_id'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
