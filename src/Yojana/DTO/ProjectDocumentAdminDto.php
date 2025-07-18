<?php

namespace Src\Yojana\DTO\ProjectDocuments\Models\ProjectDocument;

class ProjectDocumentAdminDto
{
   public function __construct(
        public string $project_id,
        public string $document_name,
        public string $data
    ){}

public static function fromLiveWireModel(ProjectDocument $projectDocument):ProjectDocumentAdminDto{
    return new self(
        project_id: $projectDocument->project_id,
        document_name: $projectDocument->document_name,
        data: $projectDocument->data
    );
}
}
