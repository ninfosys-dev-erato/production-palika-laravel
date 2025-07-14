<?php

namespace Src\Yojana\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\Yojana\Models\LogBook;

class LogBooksExport implements FromCollection
{
    public $log_books;

    public function __construct($log_books) {
        $this->log_books = $log_books;
    }

    public function collection()
    {
        return LogBook::select([
'employee_id',
'date',
'visit_time',
'return_time',
'visit_type',
'visit_purpose',
'description'
])
        ->whereIn('id', $this->log_books)->get();
    }
}


