<?php

namespace Src\AdminSettings\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\AdminSettings\Enums\ModuleEnum;

class AdminSetting extends Model
{
    use SoftDeletes;
    protected $table = 'mst_admin_settings';
    protected $fillable = [
        'group_id',
        'label', 
        'select_from',
        'value',
        'deleted_at',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function casts(): array
    {
        return [
            'group_id' => 'int',
            'label' => 'string',
            'select_from' => ModuleEnum::class,
            'value' => 'string',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'deleted_by' => 'integer',
            'deleted_at' => 'datetime',
        ];
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function group()
    {
        return $this->belongsTo(AdminSettingGroup::class, 'group_id');
    }

}
