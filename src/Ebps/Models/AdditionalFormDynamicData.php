<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Settings\Models\Form;

class AdditionalFormDynamicData extends Model
{
    protected $table = 'ebps_additional_form_dynamic_data';

    protected $fillable = [
        'map_apply_id',
        'form_id',
        'form_data',
        'deleted_at',
        'deleted_by'
    ];

    protected $casts = [
        'map_apply_id' => 'integer',
        'form_id' => 'integer',
        'form_data' => 'array',
        'deleted_at' => 'datetime',
        'deleted_by' => 'integer'

    ];

    public function mapApply(): BelongsTo
    {
        return $this->belongsTo(MapApply::class);
    }

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
