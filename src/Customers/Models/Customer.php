<?php

namespace Src\Customers\Models;

use Src\Customers\Models\Otp;
use App\Models\User;
use Database\Factories\CustomerFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Enums\LanguagePreferenceEnum;
use Src\GrantManagement\Models\Farmer;
use Src\Grievance\Models\GrievanceDetail;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, HasPermissions, HasRoles, SoftDeletes, LogsActivity;

    protected $table = 'tbl_customers';

    protected $fillable = [
        'name',
        'email',
        'mobile_no',
        'is_active',
        'password',
        'avatar',
        'gender',
        'language_preference',
        'created_by',
        'updated_by',
        'deleted_by',
        'kyc_verified_at',
        'expo_push_token',
        'notification_preference'
    ];
    protected $casts = [
        'name' => 'string',
        'email' => 'string',
        'mobile_no' => 'string',
        'is_active' => 'boolean',
        'gender' => GenderEnum::class,
        'password' => 'hashed',
        'avatar' => 'string',
        'language_preference' => LanguagePreferenceEnum::class,
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'kyc_verified_at' => 'datetime',
        'expo_push_token' => 'string',
        'notification_preference' => 'string'
    ];

    protected $hidden = [
        'password',
    ];

    public function scopeIsActive(Builder $query, bool $status = true): Builder
    {
        return $query->where('is_active', $status);
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

    public function findForPassport(string $username): Customer
    {
        return $this->where('mobile_no', $username)
            ->first();
    }

    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function kyc(): HasOne
    {
        return $this->hasOne(CustomerKyc::class, 'customer_id');
    }
    public function otp(): HasMany
    {
        return $this->hasMany(Otp::class);
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    protected static function newFactory(): Factory|CustomerFactory
    {
        return CustomerFactory::new();
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class);
    }

    public function grievances(): HasMany
    {
        return $this->hasMany(GrievanceDetail::class, 'customer_id');
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
