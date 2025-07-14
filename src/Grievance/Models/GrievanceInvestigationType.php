<?php

namespace Src\Grievance\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GrievanceInvestigationType extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gri_grievance_investigation_types';

    protected $fillable = [
        'title',
        'title_en',
        
    ];
    protected $casts = [
        'title' => 'string',
        'title_en' => 'string',
    ];

    public function appliedGrievances(): BelongsToMany
    {
        return $this->belongsToMany(GrievanceDetail::class, 'grievance_details_investigations'); 
    }


public function getActivitylogOptions(): LogOptions
{
    return LogOptions::defaults()
        ->logFillable()
        ->logOnlyDirty()
        ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
}

}
