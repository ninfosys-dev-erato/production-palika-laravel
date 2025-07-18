<?php

namespace Src\Ebps\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class OrganizationUser  extends Authenticatable
{
    use HasFactory,LogsActivity;

    protected $table = 'org_organization_users';

    protected $fillable = [
'name',
'email',
'photo',
'phone',
'password',
'is_active',
'is_organization',
'organization_id',
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
    'name' => 'string',
    'email' => 'string',
    'photo' => 'string',
    'phone' => 'string',
    'password' => 'string',
    'is_active' => 'boolean',
    'is_organization' => 'boolean',
    'organization_id' => 'string',
    'can_work' => 'boolean',
    'status' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This OrganizationUser has been {$eventName}");
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
