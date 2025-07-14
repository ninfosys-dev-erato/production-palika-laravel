<?php

namespace Src\Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{

    protected $table = 'add_provinces';

    protected $fillable = [
        'title',
        'title_en'
    ];

    protected $casts =[
        'title' => 'string',
        'title_en' => 'string'
    ];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }
}
