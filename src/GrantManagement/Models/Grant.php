<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

 /**
    * @property string $fiscal_year_id
    * @property string $grant_type_id
    * @property string $grant_office_id
    * @property string $grant_program_name
    * @property string $branch_id
    * @property string $grant_amount
    * @property string $grant_for
    * @property string $main_activity
    * @property string $remarks
    * @property string $user_id
 */

class Grant extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'gms_grants';

    protected $fillable = [
'fiscal_year_id',
'grant_type_id',
'grant_office_id',
'grant_program_name',
'branch_id',
'grant_amount',
'grant_for',
'main_activity',
'remarks',
'user_id',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'fiscal_year_id' => 'string',
    'grant_type_id' => 'string',
    'grant_office_id' => 'string',
    'grant_program_name' => 'string',
    'branch_id' => 'string',
    'grant_amount' => 'string',
    'grant_for' => 'string',
    'main_activity' => 'string',
    'remarks' => 'string',
    'user_id' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This Grant has been {$eventName}");
     }

}
