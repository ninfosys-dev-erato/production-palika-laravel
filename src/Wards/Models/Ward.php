<?php

namespace Src\Wards\Models;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Wards\Database\Factories\WardFactory;
use Src\Yojana\Models\Plan;

class Ward extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tbl_wards';
    public $incrementing = false;
    protected $fillable = [
        'id',
        'local_body_id',
        'phone',
        'email',
        'address_en',
        'address_ne',
        'ward_name_en',
        'ward_name_ne',
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
            'local_body_id' => 'string',
            'phone' => 'string',
            'email' => 'string',
            'address_en' => 'string',
            'address_ne' => 'string',
            'ward_name_en' => 'string',
            'ward_name_ne' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This Ward has been {$eventName}");
    }

    public function getDisplayNameAttribute()
    {
        return app()->getLocale() === "en" ? ($this->ward_name_en ?? $this->ward_name_ne) : ($this->ward_name_ne ?? $this->ward_name_en);
    }

    public function users()
    {
        return $this->belongsToMany(
            \App\Models\User::class,      // related model
            'tbl_users_wards',             // pivot table name
            'ward',                      // foreign key on the pivot table for the ward
            'user_id'                      // foreign key on the pivot table for the user
        );
    }

    protected static function newFactory(): WardFactory|Factory
    {
        return WardFactory::new();
    }

    public function plans() :HasMany
    {
        return $this->hasMany(Plan::class, 'ward_id');
    }
}
