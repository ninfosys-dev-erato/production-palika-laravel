<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

 /**
    * @property string $evaluation_id
    * @property string $activity_id
    * @property string $unit
    * @property string $agreement
    * @property string $before_this
    * @property string $up_to_date_amount
    * @property string $current
    * @property string $rate
    * @property string $assessment_amount
    * @property string $vat_amount
 */

class EvaluationCostDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_evaluation_cost_details';

    protected $fillable = [
'evaluation_id',
'activity_id',
'unit',
'agreement',
'before_this',
'up_to_date_amount',
'current',
'rate',
'assessment_amount',
'vat_amount',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'evaluation_id' => 'string',
    'activity_id' => 'string',
    'unit' => 'string',
    'agreement' => 'string',
    'before_this' => 'string',
    'up_to_date_amount' => 'string',
    'current' => 'string',
    'rate' => 'string',
    'assessment_amount' => 'string',
    'vat_amount' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This EvaluationCostDetail has been {$eventName}");
     }

    public function evaluation() :belongsTo
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id', 'id');
     }

    public function activity() :BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id', 'id');
     }

}
