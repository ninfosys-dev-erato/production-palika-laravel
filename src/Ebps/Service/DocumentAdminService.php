<?php

namespace Src\Ebps\Service;

use Illuminate\Support\Facades\Auth;
use Src\Ebps\DTO\DocumentAdminDto;
use Src\Ebps\Models\Document;

class DocumentAdminService
{
public function store(DocumentAdminDto $documentAdminDto){
    return Document::create([
        'title' => $documentAdminDto->title,
        'application_type' => $documentAdminDto->application_type,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Document $document, DocumentAdminDto $documentAdminDto){
    return tap($document)->update([
        'title' => $documentAdminDto->title,
        'application_type' => $documentAdminDto->application_type,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Document $document){
    return tap($document)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Document::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


