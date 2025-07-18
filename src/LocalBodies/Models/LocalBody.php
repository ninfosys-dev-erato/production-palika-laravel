<?php

namespace Src\LocalBodies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalBody extends Model
{
    use HasFactory;

    protected $table = 'add_local_bodies';

    protected $fillable = [
        'district_id',
        'title',
        'title_en',
        'wards',
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
            'district_id' => 'string',
            'title' => 'string',
            'title_en' => 'string',
            'wards' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }
}
