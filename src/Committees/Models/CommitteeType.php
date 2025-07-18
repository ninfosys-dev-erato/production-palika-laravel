<?php

namespace Src\Committees\Models;

use Database\Factories\CommitteeTypeFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Committees\Models\Committee;
use Src\Meetings\Models\Meeting;

class CommitteeType extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'met_committee_types';

    protected $fillable = [
        'name',
        'committee_no',
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
            'committee_no' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function committees(): HasMany
    {
        return $this->hasMany(Committee::class, 'committee_type_id');
    }

    public function meetings(): HasManyThrough
    {
        return $this->hasManyThrough(Meeting::class, Committee::class);
    }
    protected static function newFactory(): Factory|CommitteeTypeFactory
    {
        return CommitteeTypeFactory::new();
    }
}
