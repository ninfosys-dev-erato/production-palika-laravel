<?php

namespace Src\Yojana\Service;

use Illuminate\Support\Facades\Auth;
use Src\Yojana\DTO\ProjectDocumentAdminDto;
use Src\Yojana\Models\ProjectDocument;

class ProjectDocumentAdminService
{
public function store(ProjectDocumentAdminDto $projectDocumentAdminDto){
    return ProjectDocument::create([
        'project_id' => $projectDocumentAdminDto->project_id,
        'document_name' => $projectDocumentAdminDto->document_name,
        'data' => $projectDocumentAdminDto->data,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(ProjectDocument $projectDocument, ProjectDocumentAdminDto $projectDocumentAdminDto){
    return tap($projectDocument)->update([
        'project_id' => $projectDocumentAdminDto->project_id,
        'document_name' => $projectDocumentAdminDto->document_name,
        'data' => $projectDocumentAdminDto->data,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(ProjectDocument $projectDocument){
    return tap($projectDocument)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    ProjectDocument::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


