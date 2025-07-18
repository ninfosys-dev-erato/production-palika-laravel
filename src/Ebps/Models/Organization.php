<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\Province;
use Src\Districts\Models\District;
use Src\Ebps\Enums\OrganizationStatusEnum;
use Src\LocalBodies\Models\LocalBody;

class Organization extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'org_organizations';

    protected $fillable = [
    'org_name_ne',
    'org_name_en',
    'org_email',
    'org_contact',
    'org_registration_no',
    'org_registration_date',
    'org_registration_document',
    'org_pan_no',
    'org_pan_registration_date',
    'org_pan_document',
    'logo',
    'province_id',
    'district_id',
    'local_body_id',
    'ward',
    'tole',
    'local_body_registration_date',
    'local_body_registration_no',
    'local_body_file',
    'company_registration_document',
    'is_active',
    'is_organization',
    'can_work',
    'status',
    'comment',
    'created_at',
    'created_by',
    'deleted_at',
    'deleted_by',
    'updated_at',
    'updated_by'
    ];

    public function casts():array{
      return [
    'org_name_ne' => 'string',
    'org_name_en' => 'string',
    'org_email' => 'string',
    'org_contact' => 'string',
    'org_registration_no' => 'string',
    'org_registration_date' => 'string',
    'org_registration_document' => 'string',
    'org_pan_no' => 'string',
    'org_pan_registration_date' => 'string',
    'org_pan_document' => 'string',
    'logo' => 'string',
    'province_id' => 'string',
    'district_id' => 'string',
    'local_body_id' => 'string',
    'ward' => 'string',
    'tole' => 'string',
    'local_body_registration_date' => 'string',
    'local_body_registration_no' => 'string',
    'local_body_file' => 'string',
    'company_registration_document' => 'string',
    'is_active' => 'string',
    'is_organization' => 'string',
    'can_work' => 'string',
    'status' => OrganizationStatusEnum::class,
    'comment' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This Organization has been {$eventName}");
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

    public function taxClearances(): HasMany
    {
        return $this->hasMany(TaxClearance::class);
    }

    public function user()
    {
        return $this->hasOne(OrganizationUser::class);
    }
}
