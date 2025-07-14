<?php

namespace Src\FuelSettings\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Wards\Models\Ward;

class FuelSetting extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'fms_fuel_settings';

    protected $fillable = [
        'acceptor_id',
        'reviewer_id',
        'expiry_days',
        'ward_no',
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
            'acceptor_id' => 'string',
            'reviewer_id' => 'string',
            'expiry_days' => 'string',
            'ward_no' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This FuelSetting has been {$eventName}");
    }
    public function acceptor()
    {
        return $this->belongsTo(User::class, 'acceptor_id', 'id');
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_no');
    }
}
