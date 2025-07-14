<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LegalDocument extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_legal_documents';

    protected $fillable = [
        'complaint_registration_id',
        'party_name',
        'document_writer_name',
        'document_date',
        'document_details',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
        'template'
    ];

    public function casts(): array
    {
        return [
            'complaint_registration_id' => 'string',
            'party_name' => 'string',
            'document_writer_name' => 'string',
            'document_date' => 'string',
            'document_details' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'template' => 'string',
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This LegalDocument has been {$eventName}");
    }
    public function party()
    {
        return $this->belongsTo(Party::class, 'party_name', 'id');
    }
    public function complaintRegistration()
    {
        return $this->belongsTo(ComplaintRegistration::class, 'complaint_registration_id', 'id');
    }
    public function LegalDocumentDetail()
    {
        return $this->hasMany(LegalDocumentDetail::class);
    }
}
