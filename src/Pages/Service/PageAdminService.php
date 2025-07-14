<?php

namespace Src\Pages\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Src\Pages\DTO\PageAdminDto;
use Src\Pages\Models\Page;

class PageAdminService
{
public function store(PageAdminDto $pageAdminDto){
    return Page::create([
        'title' => $pageAdminDto->title,
        'slug' => $pageAdminDto->slug ?: Str::slug($pageAdminDto->title, '-'),
        'content' => $pageAdminDto->content,
        'created_at' => date('Y-m-d H:i:s'),
        'created_by' => Auth::user()->id,
    ]);
}
public function update(Page $page, PageAdminDto $pageAdminDto){
    return tap($page)->update([
        'slug' => $pageAdminDto->slug,
        'title' => $pageAdminDto->title,
        'content' => $pageAdminDto->content,
        'updated_at' => date('Y-m-d H:i:s'),
        'updated_by' => Auth::user()->id,
    ]);
}
public function delete(Page $page){
    return tap($page)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
public function collectionDelete(array $ids){
     $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
    Page::whereIn('id', $numericIds)->update([
        'deleted_at' => date('Y-m-d H:i:s'),
        'deleted_by' => Auth::user()->id,
    ]);
}
}


