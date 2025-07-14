<?php

namespace Src\GrantManagement\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

 /**
    * @property string $grant_id
    * @property string $grant_for
    * @property string $model_type
    * @property string $model_id
    * @property string $personal_investment
    * @property string $is_old
    * @property string $prev_fiscal_year_id
    * @property string $investment_amount
    * @property string $remarks
    * @property string $local_body_id
    * @property string $ward_no
    * @property string $village
    * @property string $tole
    * @property string $plot_no
    * @property string $contact_person
    * @property string $contact
    * @property string $user_id
 */

class GrantDetail extends Model
{
    use HasFactory,LogsActivity;

    protected $table = 'gms_grant_details';

    protected $fillable = [
'grant_id',
'grant_for',
'model_type',
'model_id',
'personal_investment',
'is_old',
'prev_fiscal_year_id',
'investment_amount',
'remarks',
'local_body_id',
'ward_no',
'village',
'tole',
'plot_no',
'contact_person',
'contact',
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
    'grant_id' => 'string',
    'grant_for' => 'string',
    'model_type' => 'string',
    'model_id' => 'string',
    'personal_investment' => 'string',
    'is_old' => 'string',
    'prev_fiscal_year_id' => 'string',
    'investment_amount' => 'string',
    'remarks' => 'string',
    'local_body_id' => 'string',
    'ward_no' => 'string',
    'village' => 'string',
    'tole' => 'string',
    'plot_no' => 'string',
    'contact_person' => 'string',
    'contact' => 'string',
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
                ->setDescriptionForEvent(fn(string $eventName) => "This GrantDetail has been {$eventName}");
     }

}
