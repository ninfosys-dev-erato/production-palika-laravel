<?php

namespace Src\Yojana\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class BenefitedMemberDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'pln_benefited_member_details';

    protected $fillable = [
'project_id',
'ward_no',
'village',
'dalit_backward_no',
'other_households_no',
'no_of_male',
'no_of_female',
'no_of_others',
'created_at',
'created_by',
'deleted_at',
'deleted_by',
'updated_at',
'updated_by'
];

    public function casts():array{
      return [
    'project_id' => 'string',
    'ward_no' => 'string',
    'village' => 'string',
    'dalit_backward_no' => 'string',
    'other_households_no' => 'string',
    'no_of_male' => 'string',
    'no_of_female' => 'string',
    'no_of_others' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This BenefitedMemberDetail has been {$eventName}");
        }

}
