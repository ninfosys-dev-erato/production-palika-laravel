<?php

namespace Src\Recommendation\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RecommendationDocument extends Model
{
    use SoftDeletes, LogsActivity;

    protected $table = 'rec_recommendation_documents';


    protected $fillable = [
        'recommendation_id',
        'title',
        'is_required',
        'accept',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'recommendation_id' => 'integer',
        'title' => 'string',
        'is_required' => 'boolean',
        'accept' => 'string',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

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

    public function recommendation()
    {
        return $this->belongsTo(Recommendation::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
