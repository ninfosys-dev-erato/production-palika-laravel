<?php

namespace Src\Users\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\Address\Models\LocalBody;

class UserWard extends Model
{
    use LogsActivity;

    protected $table = 'tbl_users_wards';

    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;

    protected $fillable = [
        'user_id',
        'ward',
        'local_body_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function localBody()
    {
        return $this->belongsTo(LocalBody::class, 'local_body_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This model has been {$eventName}");
    }
}
