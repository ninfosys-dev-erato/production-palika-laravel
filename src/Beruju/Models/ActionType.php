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

class ActionType extends Model
{
    use HasFactory, LogsActivity, HelperDate, SoftDeletes;

    protected $table = 'brj_action_types';

    protected $fillable = [
        'name_eng',
        'name_nep',
        'sub_category_id',
        'remarks',
        'form_id',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'name_eng' => 'string',
        'name_nep' => 'string',
        'sub_category_id' => 'integer',
        'remarks' => 'string',
        'form_id' => 'integer',
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
                'name_eng',
                'name_nep',
                'sub_category_id',
                'remarks',
                'form_id',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Action Type {$eventName}")
            ->useLogName('action_type');
    }

    // Relationships
    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
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

    public function actions(): HasMany
    {
        return $this->hasMany(\Src\Beruju\Models\Action::class, 'action_type_id');
    }

    // Scopes
    public function scopeWithSubCategory($query)
    {
        return $query->with('subCategory');
    }

    public function scopeBySubCategory($query, $subCategoryId)
    {
        return $query->where('sub_category_id', $subCategoryId);
    }

    // Accessors
    public function getFullNameAttribute(): string
    {
        $currentLocale = app()->getLocale();
        $name = $currentLocale === 'ne' ? $this->name_nep : $this->name_eng;
        
        if ($this->subCategory) {
            $subCategoryName = $currentLocale === 'ne' ? $this->subCategory->name_nep : $this->subCategory->name_eng;
            return $subCategoryName . ' > ' . $name;
        }
        return $name;
    }

    public function getNameAttribute(): string
    {
        $currentLocale = app()->getLocale();
        return $currentLocale === 'ne' ? $this->name_nep : $this->name_eng;
    }

    public function getHasSubCategoryAttribute(): bool
    {
        return !is_null($this->sub_category_id);
    }
}
