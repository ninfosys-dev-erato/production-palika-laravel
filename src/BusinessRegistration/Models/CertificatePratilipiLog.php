<?php

namespace Src\BusinessRegistration\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CertificatePratilipiLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brs_certificate_pratilipi_log';


    protected $fillable = [
        'user_id',
        'damage_reason',
        'entry_date',
        'business_registration_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'damage_reason' => 'string',
        'business_registration_id' => 'integer',
        'entry_date' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function businessRegistration()
    {
        return $this->belongsTo(BusinessRegistration::class, 'business_registration_id', 'id');
    }
}
