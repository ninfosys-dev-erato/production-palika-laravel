<?php

namespace Src\TaskTracking\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Src\TaskTracking\Models\Comment;

class CommentsExport implements FromCollection
{
    public $comments;

    public function __construct($comments) {
        $this->comments = $comments;
    }

    public function collection()
    {
        return Comment::select([
'task_id',
'content',
'commenter_type',
'commenter_id'
])
        ->whereIn('id', $this->comments)->get();
    }
}


