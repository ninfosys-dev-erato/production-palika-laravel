<?php

namespace Src\EmergencyContacts\Models;

use App\Models\User;
use Database\Factories\DownloadFactory;
use Database\Factories\EmergencyContactFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class EmergencyService extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'tbl_emergency_services';

    protected $fillable = [
        
        'contact_person',
        'contact_person_ne',
        'address',
        'address_ne',
        'contact_numbers',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'site_map',
        'content',
        'content_ne',
        'website_url',
        'facebook_url',
        'image'
    ];

    public function casts():array{
        return [
            'contact_person' => 'string',
            'contact_person_ne' => 'string',
            'address' => 'string',
            'address_ne' => 'string',
            'contact_numbers' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'site_map' => 'string',
            'website_url' => 'string',
            'facebook_url' => 'string',
            'image' => 'string'
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
   
    public function contact()
    {
        $this->belongsTo(EmergencyContact::class, 'emergency_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
