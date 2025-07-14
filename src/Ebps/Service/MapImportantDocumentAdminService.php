<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\MapImportantDocumentAdminDto;
use Src\Ebps\Models\MapImportantDocument;

class MapImportantDocumentAdminService
{
public function store(MapImportantDocumentAdminDto $mapImportantDocumentAdminDto){
    return MapImportantDocument::create([
        'ebps_document_id' => $mapImportantDocumentAdminDto->ebps_document_id,
        'can_be_null' => $mapImportantDocumentAdminDto->can_be_null,
        'map_important_document_type' => json_encode(explode(' ', $mapImportantDocumentAdminDto->map_important_document_type)), 
        'accepted_file_type' => $mapImportantDocumentAdminDto->accepted_file_type,
        'needs_approval' => $mapImportantDocumentAdminDto->needs_approval,
        'position' => $mapImportantDocumentAdminDto->position,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(MapImportantDocument $mapImportantDocument, MapImportantDocumentAdminDto $mapImportantDocumentAdminDto){
    return tap($mapImportantDocument)->update([
        'ebps_document_id' => $mapImportantDocumentAdminDto->ebps_document_id,
        'can_be_null' => $mapImportantDocumentAdminDto->can_be_null,
        'map_important_document_type' => $mapImportantDocumentAdminDto->map_important_document_type,
        'accepted_file_type' => $mapImportantDocumentAdminDto->accepted_file_type,
        'needs_approval' => $mapImportantDocumentAdminDto->needs_approval,
        'position' => $mapImportantDocumentAdminDto->position,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(MapImportantDocument $mapImportantDocument){
    return tap($mapImportantDocument)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    MapImportantDocument::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


