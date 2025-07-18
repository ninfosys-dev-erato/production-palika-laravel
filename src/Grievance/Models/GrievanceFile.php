<?php

namespace Src\Grievance\Models;

use Database\Factories\GrievanceFileFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class GrievanceFile extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gri_grievance_files';

    protected $fillable = [
        'grievance_detail_id',
        'file_name',

    ];
    protected $casts = [
        'grievance_detail_id' => 'integer',
        'file_name' => 'array'
    ];


    public function grievanceDetail(): BelongsTo
    {
        return $this->belongsTo(GrievanceDetail::class, 'grievance_detail_id');
    }

    protected static function newFactory(): Factory|GrievanceFileFactory
    {
        return GrievanceFileFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

}
