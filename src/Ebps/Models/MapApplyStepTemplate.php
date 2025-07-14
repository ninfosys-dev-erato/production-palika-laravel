<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Settings\Models\Form;

class MapApplyStepTemplate extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ebps_map_apply_step_templates';

    protected $fillable = [
        'map_apply_step_id',
        'form_id',
        'template',
        'data',
    ];

    public function mapApplyStep()
    {
        return $this->belongsTo(MapApplyStep::class, 'map_apply_step_id');
    }


    public function form()
    {
        return $this->belongsTo(Form::class, 'form_id');
    }
}
