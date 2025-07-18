<?php

namespace Src\Yojana\Models;

use App\Traits\HelperDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\DigitalBoard\Models\Program;
use Src\Employees\Models\Branch;
use Src\Settings\Models\FiscalYear;
use Src\Wards\Models\Ward;
use Src\Yojana\Enums\Natures;
use Src\Yojana\Enums\PlanStatus;
use Src\Yojana\Enums\PlanTypes;

class Plan extends Model
{
    use HasFactory, LogsActivity, HelperDate;

    protected $table = 'pln_plans';

    protected $fillable = [
        'project_name',
        'implementation_method_id',
        'location',
        'ward_id',
        'start_fiscal_year_id',
        'operate_fiscal_year_id',
        'area_id',
        'sub_region_id',
        'targeted_id',
        'implementation_level_id',
        'plan_type',
        'nature',
        'project_group_id',
        'purpose',
        'red_book_detail',
        'allocated_budget',
        'remaining_budget',
        'source_id',
        'program',
        'budget_head_id',
        'expense_head_id',
        'fiscal_year_id',
        'amount',
        'status',
        'department',
        'category',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    protected $casts = [
            'project_name' => 'string',
            'implementation_method_id' => 'string',
            'location' => 'string',
            'ward_id' => 'string',
            'start_fiscal_year_id' => 'string',
            'operate_fiscal_year_id' => 'string',
            'area_id' => 'string',
            'sub_region_id' => 'string',
            'targeted_id' => 'string',
            'implementation_level_id' => 'string',
            'plan_type' => PlanTypes::class,
            'nature' => Natures::class,
            'project_group_id' => 'string',
            'purpose' => 'string',
            'red_book_detail' => 'string',
            'allocated_budget' => 'string',
            'source_id' => 'string',
            'program' => 'string',
            'budget_head_id' => 'string',
            'expense_head_id' => 'string',
            'fiscal_year_id' => 'string',
            'amount' => 'string',
            'department' => 'string',
            'status' => PlanStatus::class,
//            'status' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
        ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This Plan has been {$eventName}");
    }

    public function implementationMethod(): BelongsTo
    {
        return $this->belongsTo(ImplementationMethod::class);
    }

    public function planArea(): BelongsTo
    {
        return $this->belongsTo(PlanArea::class, 'area_id', 'id');
    }

    public function subRegion(): BelongsTo
    {
        return $this->belongsTo(SubRegion::class);
    }

    public function target(): BelongsTo
    {
        return $this->belongsTo(Target::class, 'targeted_id');
    }

    public function implementationLevel(): BelongsTo
    {
        return $this->belongsTo(ImplementationLevel::class);
    }

    public function projectGroup(): BelongsTo
    {
        return $this->belongsTo(ProjectGroup::class);
    }

    public function sourceType(): BelongsTo
    {
        return $this->belongsTo(SourceType::class, 'source_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function budgetHead(): BelongsTo
    {
        return $this->belongsTo(BudgetHead::class);
    }

    public function expenseHead(): BelongsTo
    {
        return $this->belongsTo(ExpenseHead::class);
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class);
    }

    public function fiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }
    public function getFiscalYearAttribute()
    {
        return fiscalYear();
    }
    public function StartFiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'start_fiscal_year_id');
    }
    public function operateFiscalYear(): BelongsTo
    {
        return $this->belongsTo(FiscalYear::class, 'operate_fiscal_year_id');
    }

    public function budgetSources(): HasMany
    {
        return $this->hasMany(PlanBudgetSource::class);
    }
    public function budgetTransfers(): HasMany
    {
        return $this->hasMany(BudgetTransfer::class)->whereNull('deleted_at');
    }

    public function costEstimation(): HasOne
    {
        return $this->hasOne(CostEstimation::class);
    }

    public function projectIncharge(): HasMany
    {
        return $this->hasMany(ProjectIncharge::class);
    }

    public function targetEntries(): HasMany
    {
        return $this->hasMany(TargetEntry::class);
    }

    public function implementationAgencies(): HasMany
    {
        return $this->hasMany(ImplementationAgency::class);
    }

    public function workOrders(): HasMany
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function agreement(): HasOne
    {
        return $this->hasOne(Agreement::class);
    }

    public function advancePayments(): HasMany
    {
        return $this->hasMany(AdvancePayment::class);
    }

    public function evaluations(): HasMany
    {
        return $this->hasMany(Evaluation::class);
    }

    public function implementationAgency(): HasOne
    {
        return $this->hasOne(ImplementationAgency::class);
    }

    public function extensionRecords(): HasMany
    {
        return $this->hasMany(PlanExtensionRecord::class);
    }

    public function latestExtension(): HasOne
    {
        return $this->hasOne(PlanExtensionRecord::class)->latestOfMany();
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'plan_id');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->budgetSources->whereNull('deleted_at')->sum('remaining_amount') + $this->getReceivedAmountAttribute();
    }


    public function getTransferredAmountAttribute()
    {
        return $this->budgetSources->whereNull('deleted_at')->sum(function ($source) {
            return $source->transferredAmount();
        });
    }

    public function receivedTransfers(): HasMany
    {
        return $this->hasMany(BudgetTransfer::class, 'to_plan')->whereNull('deleted_at');
    }

    public function getReceivedAmountAttribute(): float|int
    {
        return $this->receivedTransfers()->whereNull('deleted_at')->sum('amount');
    }

    public function getTotalTransferAmountAttribute()
    {
        return $this->received_amount - $this->transferred_amount;
    }

    public function getTotalAdvancePaidAttribute()
    {
        return $this->advancePayments()->whereNull('deleted_at')->sum('paid_amount');
    }

    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany(); // this method returns latest payment date. used in fetching report sampanna date
    }

    public function getCreatedAtNepaliAttribute()
    {
        // this method returns nepali date for created_at for report purpose
        return $this->adToBs($this->created_at->format('Y-m-d'));
    }
    public function getTotalPaymentAttribute()
    {
        return $this->payments()->whereNull('deleted_at')->sum('total_paid_amount');
    }

    public function department() : BelongsTo
    {
        return $this->belongsTo(Branch::class, 'department');
    }
}
