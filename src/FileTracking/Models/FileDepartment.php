<?php

namespace Src\FileTracking\Models;

use Illuminate\Database\Eloquent\Model;
use Src\Employees\Models\Branch;
use Src\FileTracking\Models\FileRecord;

class FileDepartment extends Model
{

    protected $table = 'tbl_files_departments';

    protected $fillable = [
        'file_id',
        'department_id',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function file()
    {
        return $this->belongsTo(FileRecord::class);
    }

   

}
