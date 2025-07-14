<?php

namespace Src\Committees\Models;

use App\Models\User;
use Database\Factories\CommitteeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Committees\Models\CommitteeMember;
use Src\Committees\Models\CommitteeType;
use Src\Meetings\Models\Meeting;

class Committee extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'met_committees';

    protected $fillable = [
        'committee_type_id',
        'committee_name',
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
            'committee_type_id' => 'integer',
            'committee_name' => 'string',
            'user_id' => 'integer',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function committeeType(): BelongsTo
    {
        return $this->belongsTo(CommitteeType::class, 'committee_type_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function committeeMembers(): HasMany
    {
        return $this->hasMany(CommitteeMember::class,'committee_id');
    }

    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class,'committee_id');
    }

    protected static function newFactory(): Factory|CommitteeFactory
    {
        return CommitteeFactory::new();
    }
}
