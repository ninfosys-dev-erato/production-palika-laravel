<?php

namespace Src\Beruju\Models;

use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class DocumentType extends Model
{
    use HasFactory, LogsActivity, HelperDate, SoftDeletes;

    protected $table = 'brj_document_types';

    protected $fillable = [
        'name_eng',
        'name_nep',
        'remarks',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'name_eng' => 'string',
        'name_nep' => 'string',
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
                'name_eng',
                'name_nep',
                'remarks',
            ])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Document Type {$eventName}")
            ->useLogName('document_type');
    }

    // Relationships
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
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    public function scopeByLanguage($query, $language = 'en')
    {
        if ($language === 'ne') {
            return $query->whereNotNull('name_nep');
        }
        return $query->whereNotNull('name_eng');
    }

    // Accessors
    public function getNameAttribute(): string
    {
        $currentLocale = app()->getLocale();
        return $currentLocale === 'ne' ? $this->name_nep : ($this->name_eng ?: $this->name_nep);
    }

    public function getDisplayNameAttribute(): string
    {
        $currentLocale = app()->getLocale();
        $name = $currentLocale === 'ne' ? $this->name_nep : $this->name_eng;
        
        if ($currentLocale === 'ne' && !$this->name_nep) {
            return $this->name_eng;
        }
        
        if ($currentLocale === 'en' && !$this->name_eng) {
            return $this->name_nep;
        }
        
        return $name;
    }

    public function getIsSystemDefinedAttribute(): bool
    {
        return is_null($this->created_by);
    }
}
