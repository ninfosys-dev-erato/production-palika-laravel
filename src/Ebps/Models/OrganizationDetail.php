<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Src\Ebps\Models\MapApply;

class OrganizationDetail extends Model
{
    use SoftDeletes;

    protected $table = 'ebps_organization_details';

    protected $fillable = [
        'parent_id',
        'map_apply_id',
        'organization_id',
        'registration_date',
        'name',
        'contact_no',
        'email',
        'reason_of_organization_change',
        'status'
    ];

    protected $casts = [
        'id' => 'int',
        'parent_id' => 'integer',
        'organization_id' => 'integer',
        'registration_date' => 'integer',
        'map_apply_id' => 'integer',
        'name' => 'string',
        'contact_no' => 'string',
        'email' => 'string',
        'status' => 'string',
        'reason_of_organization_change' => 'string',
        'deleted_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(OrganizationDetail::class, 'parent_id');
    }

    public function mapApply(): BelongsTo
    {
        return $this->belongsTo(MapApply::class, 'map_apply_id');
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    public function parentRecursive()
{
    return $this->parent()->with('parentRecursive');
}
}
