<?php

namespace Src\Yojana\Models;

use App\Models\User;
use Database\Factories\CommitteeMemberFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Src\Address\Models\District;
use Src\Address\Models\LocalBody;
use Src\Address\Models\Province;

class CommitteeMember extends Model
{
    use SoftDeletes, Notifiable, HasFactory;

    protected $table = 'met_committee_members';

    protected $fillable = [
        'committee_id',
        'name',
        'designation',
        'phone',
        'photo',
        'email',
        'province_id',
        'district_id',
        'local_body_id',
        'ward_no',
        'tole',
        'position',
        'user_id',
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
            'committee_id' => 'string',
            'name' => 'string',
            'designation' => 'string',
            'phone' => 'string',
            'photo' => 'string',
            'email' => 'string',
            'province_id' => 'string',
            'district_id' => 'string',
            'local_body_id' => 'string',
            'ward_no' => 'string',
            'tole' => 'string',
            'position' => 'string',
            'user_id' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    protected $appends = [
        'mobile_no'
    ];
    public function mobileNo(): Attribute
    {
        return Attribute::get(fn($value, $attributes) => $attributes['phone'] ?? '');
    }
    public function committee(): BelongsTo
    {
        return $this->belongsTo(Committee::class, 'committee_id');
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    protected static function newFactory(): Factory|CommitteeMemberFactory
    {
        return CommitteeMemberFactory::new();
    }
}
