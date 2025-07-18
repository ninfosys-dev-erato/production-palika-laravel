<?php

namespace Src\DigitalBoard\Service;

use Illuminate\Support\Facades\Auth;
use Src\DigitalBoard\DTO\VideoAdminDto;
use Src\DigitalBoard\Models\Video;

class VideoAdminService
{
    public function store(VideoAdminDto $videoAdminDto)
    {
        return Video::create([
            'title' => $videoAdminDto->title,
            'url' => $videoAdminDto->url,
            'file' => $videoAdminDto->file,
            'can_show_on_admin' => $videoAdminDto->can_show_on_admin,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Video $video, VideoAdminDto $videoAdminDto)
    {
        return tap($video)->update([
            'title' => $videoAdminDto->title,
            'url' => $videoAdminDto->url,
            'file' => $videoAdminDto->file,
            'can_show_on_admin' => $videoAdminDto->can_show_on_admin,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Video $video)
    {
        return tap($video)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Video::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function storeVideoWards(Video $video, array $wards) {
        $video->wards()->delete();
        $wardData = array_map(fn($wardId) => ['ward' => $wardId], $wards);
        $video->wards()->createMany($wardData);
    }


    public function toggleCanShowOnAdmin(Video $video): void
    {
        $canShowOnAdmin = !$video->can_show_on_admin;

        $video->update([
            'can_show_on_admin' => $canShowOnAdmin,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
    }


    public function deleteVideoWards(Video $video)
    {
        $video->wards()?->delete();
    }
}
