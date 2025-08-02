<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;
use Src\Customers\Models\Customer;
use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Enums\OwnershipTypeEnum;
use Src\Settings\Models\FiscalYear;
use Src\Ebps\Models\HouseOwnerDetail;

class MapApply extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_applies';

    protected $fillable = [
        'submission_id',
        'registration_date',
        'registration_no',
        'fiscal_year_id',
        'customer_id',
        'land_detail_id',
        'construction_type_id',
        'usage',
        'is_applied_by_customer',
        'full_name',
        'age',
        'applied_date',
        'signature',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'application_type',
        'map_process_type',
        'building_structure',
        'house_owner_id',
        'area_of_building_plinth',
        'no_of_rooms',
        'storey_no',
        'year_of_house_built',
        'land_owner_id',
        'applicant_type',
        'mobile_no',
        'province_id',
        'district_id', 
        'local_body_id',
        'ward_no',
        'application_date'

    ];


    public function casts():array{
      return [
        'submission_id' => 'string',
        'registration_date' => 'string',
        'registration_no' => 'string',
        'fiscal_year_id' => 'integer',
        'customer_id' => 'string',
        'land_detail_id' => 'string',
        'construction_type_id' => 'string',
        'usage' => 'string',
        'is_applied_by_customer' => 'string',
        'full_name' => 'string',
        'age' => 'string',
        'applied_date' => 'string',
        'signature' => 'string',
        'id' => 'int',
        'created_at' => 'datetime',
        'created_by' => 'string',
        'updated_at' => 'datetime',
        'updated_by' => 'string',
        'deleted_at' => 'datetime',
        'deleted_by' => 'string',
        'application_type'=> 'string',
        'house_owner_id'=> 'int',
        'map_process_type'=> 'string',
        'building_structure'=> 'string',
        'area_of_building_plinth' => 'string',
        'no_of_rooms' => 'string',
        'storey_no' => 'string',
        'year_of_house_built' => 'string',
        'land_owner_id' => 'string',
        'applicant_type' => 'string',
        'mobile_no' => 'string',
        'province_id' => 'string',
        'district_id' => 'string', 
        'local_body_id' => 'string',
        'ward_no' => 'string',
        'application_date' => 'string'
        ];
    }

    /**
     * Get the fiscal year associated with the MapApply.
     */
    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    /**
     * Get the customer who applied for the map.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the land details associated with the MapApply.
     */
    public function landDetail()
    {
        return $this->belongsTo(CustomerLandDetail::class);
    }

    /**
     * Get the construction type for the MapApply.
     */
    public function constructionType()
    {
        return $this->belongsTo(ConstructionType::class, 'construction_type_id');
    }
    public function buildingConstructionType()
    {
        return $this->belongsTo(BuildingConstructionType::class, 'construction_type_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This MapApply has been {$eventName}");
    }

    public function mapApplySteps(): HasMany
    {
        return $this->hasMany(MapApplyStep::class);
    }

    public function storeyDetails(): HasMany
    {
        return $this->hasMany(StoreyDetail::class);
    }
    public function distanceToWalls(): HasMany
    {
        return $this->hasMany(DistanceToWall::class);
    }
    public function roads(): HasMany
    {
        return $this->hasMany(Road::class);
    }
    public function cantileverDetails(): HasMany
    {
        return $this->hasMany(CantileverDetail::class);
    }
    public function highTensionLineDetails(): HasMany
    {
        return $this->hasMany(HighTensionLineDetail::class);
    }
    public function houseOwner()
    {
        return $this->belongsTo(HouseOwnerDetail::class, 'house_owner_id');
    }
    
    public function landOwner()
    {
        return $this->belongsTo(HouseOwnerDetail::class, 'land_owner_id')
                    ->where('ownership_type', OwnershipTypeEnum::LAND_OWNER->value);
    }

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function localBody(): BelongsTo
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id');
    }

    public function detail()
    {
        return $this->hasOne(MapApplyDetail::class);
    }

    public function buildingRoofType()
    {
        return $this->belongsTo(BuildingRoofType::class, 'building_roof_type_id');

    }
    
    public function organizationDetails()
    {
        return $this->hasMany(OrganizationDetail::class);
    }
}
