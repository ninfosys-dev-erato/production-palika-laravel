<?php

namespace Src\Beruju\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Src\Beruju\Enums\BerujuAduitTypeEnum;
use Src\Beruju\Enums\BerujuCategoryEnum;
use Src\Beruju\Enums\BerujuStatusEnum;
use Src\Beruju\Enums\BerujuSubmissionStatusEnum;
use Src\Beruju\Enums\BerujuCurrencyTypeEnum;
use Src\FiscalYears\Models\FiscalYear;
use Src\Employees\Models\Branch;
use Src\Beruju\Models\SubCategory;
use Src\Yojana\Models\Project;

class BerujuEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'brj_beruju_entries';

    protected $fillable = [

        'fiscal_year_id',
        'audit_type',
        'entry_date',
        'reference_number',
        'branch_id',
        'project_id',
        'beruju_category',
        'sub_category_id',
        'amount',
        'currency_type',
        'legal_provision',
        'action_deadline',
        'description',
        'notes',
        // Additional fields
        'status',
        'submission_status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'fiscal_year_id' => 'string',
        'audit_type' => BerujuAduitTypeEnum::class,
        'entry_date' => 'string',
        'reference_number' => 'string',
        'branch_id' => 'string',
        'project_id' => 'string',
        'beruju_category' => BerujuCategoryEnum::class,
        'sub_category_id' => 'string',
        'amount' => 'string',
        'currency_type' => BerujuCurrencyTypeEnum::class,
        'legal_provision' => 'string',
        'action_deadline' => 'string',
        'description' => 'string',
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

}
