<?php

namespace Src\FuelSettings\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Employees\Models\Employee;

class Vehicle extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fms_vehicles';

    protected $fillable = [
        'employee_id',
        'vehicle_category_id',
        'vehicle_number',
        'chassis_number',
        'engine_number',
        'fuel_type',
        'driver_name',
        'license_number',
        'license_photo',
        'signature',
        'driver_contact_no',
        'vehicle_detail',
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
            'employee_id' => 'string',
            'vehicle_category_id' => 'string',
            'vehicle_number' => 'string',
            'chassis_number' => 'string',
            'engine_number' => 'string',
            'fuel_type' => 'string',
            'driver_name' => 'string',
            'license_number' => 'string',
            'license_photo' => 'string',
            'signature' => 'string',
            'driver_contact_no' => 'string',
            'vehicle_detail' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Vehicle has been {$eventName}");
    }
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function vehicleCategory()
    {
        return $this->belongsTo(VehicleCategory::class, 'vehicle_category_id');
    }
}
