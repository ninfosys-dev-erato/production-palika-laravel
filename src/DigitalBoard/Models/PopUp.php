<?php

namespace Src\DigitalBoard\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PopUp extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'tbl_pop_ups';

    protected $fillable = [
        'title',
        'photo',
        'is_active',
        'display_duration',
        'iteration_duration',
        'can_show_on_admin',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'title' => 'string',
            'photo' => 'string',
            'is_active' => 'boolean',
            'display_duration' => 'int',
            'iteration_duration' => 'int',
            'can_show_on_admin' => 'boolean',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    public function scopeStartDate(Builder $query, $date): Builder
    {
        $date =  $this->bsToAd($date);
        return $query->where('created_at', '>=', Carbon::parse($date)->startOfDay());
    }
    
    public function scopeEndDate(Builder $query, $date): Builder
    {
        $date =  $this->bsToAd($date);
        return $query->where('created_at', '<=', Carbon::parse($date)->endOfDay());
    }    

    public function wards(): HasMany
    {
        return $this->hasMany(PopupWard::class, 'popup_id', 'id');
    }
}
