<?php

namespace Src\Settings\Models;

use App\Models\User;
use Database\Factories\FiscalYearFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\GrantManagement\Models\GrantProgram;
use Src\Recommendation\Models\ApplyRecommendation;

class FiscalYear extends Model
{
    use SoftDeletes, HasFactory, LogsActivity;
    protected $table = 'mst_fiscal_years';
    protected $fillable = [
        'year',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
    protected $casts = [
        'year' => 'string',
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

    protected static function newFactory(): FiscalYearFactory|Factory
    {
        return FiscalYearFactory::new();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }

    public function recommendations()
    {
        return $this->hasMany(ApplyRecommendation::class);
    }

    public function grantProgram()
    {
        return $this->belongsTo(GrantProgram::class);
    }


}
