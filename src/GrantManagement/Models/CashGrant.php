<?php

namespace Src\GrantManagement\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Customers\Models\Customer;
use Src\GrantManagement\Models\HelplessnessType;

/**
 * @property string $name
 * @property string $address
 * @property string $age
 * @property string $contact
 * @property string $citizenship_no
 * @property string $father_name
 * @property string $grandfather_name
 * @property string $helplessness_type_id
 * @property string $cash
 * @property string $file
 * @property string $remark
 */

class CashGrant extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'gms_cash_grants';

    protected $fillable = [
        'name',
        'address', // ward_id
        'age',
        'contact',
        'citizenship_no',
        'father_name',
        'grandfather_name',
        'helplessness_type_id',
        'cash',
        'file',
        'remark',
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
            'name' => 'string',
            'address' => 'string',
            'age' => 'string',
            'contact' => 'string',
            'citizenship_no' => 'string',
            'father_name' => 'string',
            'grandfather_name' => 'string',
            'helplessness_type_id' => 'string',
            'cash' => 'string',
            'file' => 'string',
            'remark' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function ward()
    {
        return $this->belongsTo(\Src\Wards\Models\Ward::class, 'address');
    }

    public function user()
    {
        return $this->belongsTo(Customer::class, 'name');
    }

    public function getHelplessnessType()
    {
        return $this->belongsTo(HelplessnessType::class, 'helplessness_type_id');
    }


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This CashGrant has been {$eventName}");
    }

}
