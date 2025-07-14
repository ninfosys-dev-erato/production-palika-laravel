<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Enums\OrganizationTypes;

/**
 * @property string $type
 * @property string $name
 * @property string $address
 * @property string $pan_number
 * @property string $phone_number
 * @property string $bank_name
 * @property string $branch
 * @property string $account_number
 * @property string $representative
 * @property string $post
 * @property string $representative_address
 * @property string $mobile_number
 */

class Organization extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_organizations';

    protected $fillable = [
        'type',
        'name',
        'address',
        'pan_number',
        'phone_number',
        'bank_name',
        'branch',
        'account_number',
        'representative',
        'post',
        'representative_address',
        'mobile_number',
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
            'type' => OrganizationTypes::class,
            'name' => 'string',
            'address' => 'string',
            'pan_number' => 'string',
            'phone_number' => 'string',
            'bank_name' => 'string',
            'branch' => 'string',
            'account_number' => 'string',
            'representative' => 'string',
            'post' => 'string',
            'representative_address' => 'string',
            'mobile_number' => 'string',
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
}
