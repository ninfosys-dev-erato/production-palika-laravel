<?php

namespace Src\Beruju\Models;

use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class SubCategory extends Model
{
    use HasFactory, LogsActivity, HelperDate, SoftDeletes;

    protected $table = 'brj_sub_categories';

    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'parent_name',
        'parent_slug',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string',
        'parent_id' => 'integer',
        'parent_name' => 'string',
        'parent_slug' => 'string',
        'remarks' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'name',
                'slug',
                'parent_id',
                'parent_name',
                'parent_slug',
                'remarks',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Sub Category {$eventName}")
            ->useLogName('sub_category');
    }

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(SubCategory::class, 'parent_id');
    }

    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }

    public function ancestors(): BelongsTo
    {
        return $this->parent()->with('ancestors');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Scopes
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeWithChildren($query)
    {
        return $query->with('children');
    }

    public function scopeWithParent($query)
    {
        return $query->with('parent');
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        if ($this->parent) {
            return $this->parent->name . ' > ' . $this->name;
        }
        return $this->name;
    }

    public function getChildrenCountAttribute(): int
    {
        return $this->children()->count();
    }

    public function getIsRootAttribute(): bool
    {
        return is_null($this->parent_id);
    }

    public function getHasChildrenAttribute(): bool
    {
        return $this->children()->exists();
    }
}
