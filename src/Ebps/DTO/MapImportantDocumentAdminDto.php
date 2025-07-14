<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Models\MapImportantDocument;

class MapImportantDocumentAdminDto
{
   public function __construct(
        public string $ebps_document_id,
        public bool $can_be_null,
        public string $map_important_document_type,
        public string $accepted_file_type,
        public bool $needs_approval,
        public string $position
    ){}

public static function fromLiveWireModel(MapImportantDocument $mapImportantDocument):MapImportantDocumentAdminDto{
    return new self(
        ebps_document_id: $mapImportantDocument->ebps_document_id,
        can_be_null: $mapImportantDocument->can_be_null ?? 0,
        map_important_document_type: $mapImportantDocument->map_important_document_type,
        accepted_file_type: $mapImportantDocument->accepted_file_type,
        needs_approval: $mapImportantDocument->needs_approval ?? 0,
        position: $mapImportantDocument->position
    );
}
}
