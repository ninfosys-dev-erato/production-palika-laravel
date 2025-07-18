<?php

namespace Src\BusinessRegistration\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NatureOfBusiness extends Model
{
    use HasFactory;

    protected $table = "brs_nature_of_business";

    protected $fillable = [
        'title',
        'title_ne',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    protected function casts(): array
    {
        return [
            'title' => 'string',
            'title_ne' => 'string',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function businessRegistration(): HasMany
    {
        return $this->hasMany(BusinessRegistration::class);
    }
}
