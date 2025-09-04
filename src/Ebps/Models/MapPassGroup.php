<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Models\User;

class MapPassGroup extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'ebps_map_pass_groups';

    protected $fillable = [
        'title',
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
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];
    }

    // public function users(): HasMany
    // {
    //     return $this->hasMany(MapPassGroupUser::class, 'map_pass_group_id', 'id');
    // }
    // public function users(): HasMany
    // {
    //     return $this->hasMany(MapPassGroupUser::class, 'map_pass_group_id', 'id');
    // }

    public function groupUsers(): HasMany
    {
        return $this->hasMany(MapPassGroupUser::class, 'map_pass_group_id', 'id');
    }

    public function mapPassGroupMapSteps(): HasMany
    {
        return $this->hasMany(MapPassGroupMapStep::class, 'map_pass_group_id', 'id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This MapPassGroup has been {$eventName}");
    }

    public function steps(): BelongsToMany
    {
        return $this->belongsToMany(MapStep::class, 'ebps_map_pass_group_map_step', 'map_pass_group_id', 'map_step_id')
            ->withPivot('type', 'position')
            ->withTimestamps();
    }

    public function submitterSteps(): BelongsToMany
    {
        return $this->belongsToMany(MapStep::class, 'ebps_map_pass_group_map_step', 'map_pass_group_id', 'map_step_id')
            ->withPivot('type', 'position')
            ->wherePivot('type', 'submitter')
            ->orderBy('position');
    }

    public function approverSteps(): BelongsToMany
    {
        return $this->belongsToMany(MapStep::class, 'ebps_map_pass_group_map_step', 'map_pass_group_id', 'map_step_id')
            ->withPivot('type', 'position')
            ->wherePivot('type', 'approver')
            ->orderBy('position');
    }

    // Helper methods
    public function getUsers()
    {
        return $this->users()->with('user')->get()->pluck('user');
    }

    public function hasUser($userId): bool
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    public function addUser($userId, $wardNo = null)
    {
        return $this->users()->create([
            'user_id' => $userId,
            'ward_no' => $wardNo,
        ]);
    }

    public function removeUser($userId)
    {
        return $this->users()->where('user_id', $userId)->delete();
    }

    // In MapPassGroup.php
public function users(): BelongsToMany
{
    return $this->belongsToMany(
        User::class,               // User model
        'ebps_map_pass_group_user',     // Pivot table linking users to groups
        'map_pass_group_id',       // This model key on pivot
        'user_id'                  // User key on pivot
    );
}

}
