<?php

namespace Src\Grievance\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GrievanceTypesRole extends Model
{
    use LogsActivity;
    protected $table = "tbl_grievance_types_roles";

    protected $fillable = ['grievance_type_id', 'role_id', 'created_at', 'updated_at'];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
    
}
