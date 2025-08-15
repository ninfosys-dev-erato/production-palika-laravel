<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Src\Settings\Models\Form;

class AdditionalForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ebps_additional_forms';

    protected $fillable = [
        'name',
        'form_id',
        'status',
        'created_by',
        'deleted_by',
    ];

    protected $casts = [
        'name' => 'string',
        'form_id' => 'integer',
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class, 'form_id', 'id');
    }
}
