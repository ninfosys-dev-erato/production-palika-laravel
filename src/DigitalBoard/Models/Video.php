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

class Video extends Model
{
    use HasFactory, SoftDeletes, LogsActivity, HelperDate;

    protected $table = 'tbl_videos';

    protected $fillable = [
        'title',
        'url',
        'file',
        'can_show_on_admin',
        'is_private',
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
            'url' => 'string',
            'file' => 'string',
            'can_show_on_admin' => 'boolean',
            'is_private' => 'boolean',
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
        $date = $this->bsToAd(($date));
        return $query->where('created_at', '<=', Carbon::parse($date)->endOfDay());
    }    

    public function wards(): HasMany
    {
        return $this->hasMany(VideoWard::class, 'video_id', 'id');
    }
}
