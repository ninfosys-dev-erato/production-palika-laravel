<?php

namespace Src\Beruju\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use Src\Beruju\Enums\BerujuAduitTypeEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use Src\Beruju\Enums\BerujuCurrencyTypeEnum;
use Src\FiscalYears\Models\FiscalYear;
use Src\Employees\Models\Branch;
use Src\Beruju\Models\SubCategory;
use Src\Beruju\Models\ResolutionCycle;
use Src\Yojana\Models\Project;

class BerujuEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brj_beruju_entries';

    protected $fillable = [
        'name',
        'fiscal_year_id',
        'audit_type',
        'entry_date',
        'reference_number',
        'contract_number',
        'branch_id',
        'project',
        'beruju_category',
        'sub_category_id',
        'amount',
        'currency_type',
        'legal_provision',
        'action_deadline',
        'description',
        'beruju_description',
        'owner_name',
        'dafa_number',
        'notes',
        // Additional fields
        'status',
        'submission_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'name' => 'string',
        'fiscal_year_id' => 'string',
        'audit_type' => BerujuAduitTypeEnum::class,
        'entry_date' => 'string',
        'reference_number' => 'string',
        'branch_id' => 'string',
        'project' => 'string',
        'beruju_category' => BerujuCategoryEnum::class,
        'sub_category_id' => 'string',
        'amount' => 'string',
        'currency_type' => BerujuCurrencyTypeEnum::class,
        'legal_provision' => 'string',
        'action_deadline' => 'string',
        'description' => 'string',
        'beruju_description' => 'string',
        'owner_name' => 'string',
        'dafa_number' => 'string',
        'notes' => 'string',


        'status' => BerujuStatusEnum::class,
        'submission_status' => BerujuSubmissionStatusEnum::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deleter()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id');
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function fiscalYear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }
    // Relationships
    public function evidences()
    {
        return $this->hasMany(Evidence::class, 'beruju_entry_id');
    }

    public function resolutionCycles() : HasMany
    {
        return $this->hasMany(ResolutionCycle::class, 'beruju_id');
    }

    /**
     * Get the latest resolution cycle for this beruju entry
     */
    public function latestResolutionCycle()
    {
        return $this->hasOne(ResolutionCycle::class, 'beruju_id')->latestOfMany();
    }

    /**
     * Calculate the total resolved amount from the latest resolution cycle
     */
    public function getResolvedAmountAttribute()
    {
        $latestCycle = $this->latestResolutionCycle;
        
        if (!$latestCycle) {
            return 0;
        }

        // Use the already loaded actions relationship if available
        if ($latestCycle->relationLoaded('actions')) {
            return $latestCycle->actions
                ->whereNotNull('resolved_amount')
                ->sum('resolved_amount');
        }

        // Fallback to query if relationship not loaded
        return $latestCycle->actions()
            ->whereNotNull('resolved_amount')
            ->sum('resolved_amount');
    }

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->resolved_amount;
    }

}
