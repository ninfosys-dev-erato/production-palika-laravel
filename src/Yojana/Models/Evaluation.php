<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Yojana\Enums\Installments;

/**
 * @property string $plan_id
 * @property string $evaluation_date
 * @property string $completion_date
 * @property Installments $installment_no
 * @property string $up_to_date_amount
 * @property string $assessment_amount
 * @property string $is_implemented
 * @property string $is_budget_utilized
 * @property string $is_quality_maintained
 * @property string $is_reached
 * @property string $is_tested
 * @property string $testing_date
 * @property string $attendance_number
 * @property string $evaluation_no
 * @property string $ward_recommendation_document
 * @property string $technical_evaluation_document
 * @property string $committee_report
 * @property string $attendance_report
 * @property string $construction_progress_photo
 * @property string $work_completion_report
 * @property string $expense_report
 * @property string $other_document
 * @property boolean $is_vatable
 */

class Evaluation extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'pln_evaluations';

    protected $fillable = [
        'plan_id',
        'evaluation_date',
        'completion_date',
        'installment_no',
        'up_to_date_amount',
        'assessment_amount',
        'evaluation_amount',
        'total_vat',
        'is_implemented',
        'is_budget_utilized',
        'is_quality_maintained',
        'is_reached',
        'is_tested',
        'testing_date',
        'attendance_number',
        'evaluation_no',
        'ward_recommendation_document',
        'technical_evaluation_document',
        'committee_report',
        'attendance_report',
        'construction_progress_photo',
        'work_completion_report',
        'expense_report',
        'other_document',
        'is_vatable',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    protected $casts = [
            'plan_id' => 'string',
            'evaluation_date' => 'string',
            'completion_date' => 'string',
            'installment_no' => Installments::class,
            'up_to_date_amount' => 'string',
            'evaluation_amount' => 'string',
            'total_vat' => 'string',
            'assessment_amount' => 'string',
            'is_implemented' => 'boolean',
            'is_budget_utilized' => 'boolean',
            'is_quality_maintained' => 'boolean',
            'is_reached' => 'boolean',
            'is_tested' => 'boolean',
            'testing_date' => 'string',
            'attendance_number' => 'string',
            'evaluation_no' => 'string',
            'ward_recommendation_document' => 'string',
            'technical_evaluation_document' => 'string',
            'committee_report' => 'string',
            'attendance_report' => 'string',
            'construction_progress_photo' => 'string',
            'work_completion_report' => 'string',
            'expense_report' => 'string',
            'other_document' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'is_vatable' => 'boolean'
        ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Evaluation has been {$eventName}");
    }
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'evaluation_id', 'id');
    }

    public function costDetails(): HasMany
    {
        return $this->hasMany(EvaluationCostDetail::class, 'evaluation_id', 'id');
    }
}
