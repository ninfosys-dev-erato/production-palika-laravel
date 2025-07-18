<?php

namespace Src\Downloads\Service;

use Illuminate\Support\Facades\Auth;
use Src\Downloads\DTO\DownloadAdminDto;
use Src\Downloads\Models\Download;

class DownloadAdminService
{
public function store(DownloadAdminDto $downloadAdminDto){
    return Download::create([
        'title' => $downloadAdminDto->title,
        'title_en' => $downloadAdminDto->title_en,
        'files' => $downloadAdminDto->files,
        'status' => $downloadAdminDto->status,
        'order' => $downloadAdminDto->order,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Download $download, DownloadAdminDto $downloadAdminDto){
    return tap($download)->update([
        'title' => $downloadAdminDto->title,
        'title_en' => $downloadAdminDto->title_en,
        'files' => $downloadAdminDto->files,
        'status' => $downloadAdminDto->status,
        'order' => $downloadAdminDto->order,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Download $download){
    return tap($download)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Download::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


