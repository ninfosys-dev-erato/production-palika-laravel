<?php

namespace Src\DigitalBoard\Models;

use App\Traits\HelperDate;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Program extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HelperDate;

    protected $table = 'tbl_programs';

    protected $fillable = [
        'title',
        'photo',
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
            'can_show_on_admin' => 'boolean',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }


    public function wards(): HasMany
    {
        return $this->hasMany(ProgramWard::class, 'program_id', 'id');
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
