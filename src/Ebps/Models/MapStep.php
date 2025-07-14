<?php

namespace Src\Ebps\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Settings\Models\Form;

class MapStep extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'ebps_map_steps';

    /**
    * @property int $title
    * @property bool $is_public
    * @property bool $can_skip
    * @property string $form_submitter
    * @property string $form_position
    * @property string $step_for
    * @property string $application_type
    * @property int $created_by
    * @property int $updated_by
    * @property int $deleted_by
    * @property \Carbon\Carbon|null $created_at
    * @property \Carbon\Carbon|null $updated_at
    * @property \Carbon\Carbon|null $deleted_at
    */
    protected $fillable = [
        'title',
        'is_public',
        'can_skip',
        'form_submitter',
        'form_position',
        'application_type',
        'step_for',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts():array{
        return [
            'title' => 'string',
            'is_public' => 'string',
            'can_skip' => 'string',
            'form_submitter' => 'string',
            'form_position' => 'int',
            'application_type' => 'string',
            'step_for' => 'string',
            'id' => 'int',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This MapStep has been {$eventName}");
    }
    public function form(): BelongsToMany
    {
        return $this->belongsToMany(Form::class, 'ebps_form_map_step');
    }
    public function constructionTypes(): BelongsToMany
    {
        return $this->belongsToMany(ConstructionType::class, 'ebps_construction_type_map_step');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(MapPassGroup::class, 'ebps_map_pass_group_map_step');
    }

}
