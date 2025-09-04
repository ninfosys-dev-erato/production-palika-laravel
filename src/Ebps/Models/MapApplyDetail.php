<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class MapApplyDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ebps_map_apply_details';

    protected $fillable = [
        'map_apply_id',
        'organization_id',
        'land_use_area_id',
        'land_use_area_changes',
        'usage_changes',
        'change_acceptance_type',
        'field_measurement_area',
        'building_plinth_area',
        'building_construction_type_id',
        'construction_purpose_id',
        'building_roof_type_id',
        'other_construction_area',
        'former_other_construction_area',
        'public_property_name',
        'material_used',
        'distance_left',
        'area_unit',
        'length_unit',
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
            'map_apply_id' => 'string',
            'organization_id' => 'string',
            'land_use_area_id' => 'string',
            'land_use_area_changes' => 'string',
            'usage_changes' => 'string',
            'change_acceptance_type' => 'string',
            'field_measurement_area' => 'string',
            'building_plinth_area' => 'string',
            'building_construction_type_id' => 'string',
            'construction_purpose_id' => 'string',
            'building_roof_type_id' => 'string',
            'other_construction_area' => 'string',
            'former_other_construction_area' => 'string',
            'public_property_name' => 'string',
            'material_used' => 'string',
            'distance_left' => 'string',
            'area_unit' => 'string',
            'length_unit' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This MapApplyDetail has been {$eventName}");
    }

    public function mapApply()
    {
        return $this->belongsTo(MapApply::class, 'map_apply_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }
    public function landUseArea()
    {
        return $this->belongsTo(LandUseArea::class, 'land_use_area_id');
    }
    public function buildingConstructionType()
    {

        return $this->belongsTo(BuildingConstructionType::class, 'building_construction_type_id');
    }
    public function buildingRoofType()
    {
        return $this->belongsTo(BuildingRoofType::class, 'building_roof_type_id');
    }
}
