<?php

namespace Src\BusinessRegistration\Models;

use App\Facades\FileFacade;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Src\BusinessRegistration\Enums\BusinessDocumentStatusEnum;

class BusinessRenewalDocument extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'brs_business_renewal_documents';

    protected $fillable = [
        'business_registration_id',
        'business_renewal',
        'document_name',
        'document',
        'document_details',
        'document_status',
        'comment_log',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by'
    ];

    public function casts(): array
    {
        return [
            'business_registration_id' => 'string',
            'business_renewal' => 'string',
            'document_name' => 'string',
            'document' => 'string',
            'document_details' => 'string',
            'document_status' => BusinessDocumentStatusEnum::class,
            'comment_log' => 'string',
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
            ->setDescriptionForEvent(fn(string $eventName) => "This BusinessRenewalDocument has been {$eventName}");
    }

    protected function url(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Check if file attribute exists
                if (empty($this->document)) {
                    return null;
                }
                // For private files, generate a temporary signed URL
                return FileFacade::getTemporaryUrl(
                    path:config("src.BusinessRegistration.businessRegistration.registration_document"),
                    filename:$this->document,
                    disk: getStorageDisk('private'),
                    minutes:10,
                );
            }
        );
    }

}
