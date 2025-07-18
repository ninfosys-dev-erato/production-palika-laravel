<?php

namespace Src\Address\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LocalBody extends Model
{
    protected $table = 'add_local_bodies';

    protected $fillable = [
        'district_id',
        'title',
        'title_en',
        'wards',
    ];

    protected $casts = [
        'district_id' => 'int',
        'title' => 'string',
        'title_en' => 'string',
        'wards' => 'int',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function wardsArray(): Attribute
    {
        return Attribute::get(fn($value, $attributes) => range(1, $attributes['wards']));
    }

}
