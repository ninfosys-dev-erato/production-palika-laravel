<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdditionalFormDynamicData extends Model
{
    protected $table = 'ebps_additional_form_dynamic_data';

    protected $fillable = [
        'map_apply_id',
        'additional_form_id',
        'form_data'
    ];

    protected $casts = [
        'map_apply_id' => 'integer',
        'additional_form_id' => 'integer',
        'form_data' => 'array'
    ];

    public function mapApply(): BelongsTo
    {
        return $this->belongsTo(MapApply::class);
    }

    public function additionalForm(): BelongsTo
    {
        return $this->belongsTo(AdditionalForm::class);
    }
}
