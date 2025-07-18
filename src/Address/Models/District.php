<?php

namespace Src\Address\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $table = 'add_districts';

    protected $fillable = [
        'province_id',
        'title',
        'title_en'
    ];

    protected $casts = [
        'province_id' => 'int',
        'title' => 'string',
        'title_en' => 'string',
    ];

    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    public function localBodies(): HasMany
    {
        return $this->hasMany(LocalBody::class);
    }
}
