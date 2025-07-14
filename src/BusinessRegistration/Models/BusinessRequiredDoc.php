<?php

namespace Src\BusinessRegistration\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessRequiredDoc extends Model
{
    protected $table = 'brs_businessRequiredDoc';

    protected $fillable = [
        'business_registration_id',
        'document_field',
        'document_label_en',
        'document_label_ne',
        'document_filename',
    ];

    protected $casts = [
        'business_registration_id' => 'integer',
        'document_field' => 'string',
        'document_label_en' => 'string',
        'document_label_ne' => 'string',
        'document_filename' => 'string',
    ];
}
