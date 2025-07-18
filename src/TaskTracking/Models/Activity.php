<?php

namespace Src\TaskTracking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Activity extends Model
{
    use HasFactory;

    protected $table = "tms_activities";

    protected $fillable = [
        'task_id', 
        'action', 
        'user_id', 
        'user_type', 
        'description', 
        'created_at'
    ];

    // Defines the relationship to the Task model
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    // Optional: Defines the relationship to a user (could be reporter, assignee, etc.)
    public function user(): MorphTo
    {
        return $this->morphTo();
    }
}
