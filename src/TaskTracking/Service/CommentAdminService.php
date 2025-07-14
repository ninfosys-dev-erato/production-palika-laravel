<?php

namespace Src\TaskTracking\Service;

use Illuminate\Support\Facades\Auth;
use Src\TaskTracking\DTO\CommentAdminDto;
use Src\TaskTracking\Models\Comment;

class CommentAdminService
{
public function store(CommentAdminDto $commentAdminDto){
    return Comment::create([
        'task_id' => $commentAdminDto->task_id,
        'content' => $commentAdminDto->content,
        'commenter_type' => $commentAdminDto->commenter_type,
        'commenter_id' => $commentAdminDto->commenter_id,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Comment $comment, CommentAdminDto $commentAdminDto){
    return tap($comment)->update([
        'task_id' => $commentAdminDto->task_id,
        'content' => $commentAdminDto->content,
        'commenter_type' => $commentAdminDto->commenter_type,
        'commenter_id' => $commentAdminDto->commenter_id,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Comment $comment){
    return tap($comment)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Comment::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


