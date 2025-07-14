<?php

namespace Src\Ejalas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class LegalDocumentDetail extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'jms_legal_document_details';

    protected $fillable = [
        'party_name',
        'statement_giver',
        'document_writer_name',
        'document_date',
        'document_details',
        'legal_document_id',
        'created_at',
        'created_by',
        'deleted_at',
        'deleted_by',
        'updated_at',
        'updated_by',
    ];

    public function casts(): array
    {
        return [
            'party_name' => 'string',
            'document_writer_name' => 'string',
            'document_date' => 'string',
            'document_details' => 'string',
            'document_signer' => 'string',
            'id' => 'int',
            'created_at' => 'datetime',
            'created_by' => 'string',
            'updated_at' => 'datetime',
            'updated_by' => 'string',
            'deleted_at' => 'datetime',
            'deleted_by' => 'string',
            'template' => 'string',
            'legal_document_id' => 'string'
        ];
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "This LegalDocument has been {$eventName}");
    }
}
