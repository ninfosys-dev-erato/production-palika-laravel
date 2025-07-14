<?php

namespace Src\DigitalBoard\Service;

use Illuminate\Support\Facades\Auth;
use Src\DigitalBoard\DTO\NoticeAdminDto;
use Src\DigitalBoard\Models\Notice;

class NoticeAdminService
{
    public function store(NoticeAdminDto $noticeAdminDto): Notice | bool
    {
        return Notice::create([
            'title' => $noticeAdminDto->title,
            'date' => $noticeAdminDto->date,
            'file' => $noticeAdminDto->file,
            'can_show_on_admin' => $noticeAdminDto->can_show_on_admin,
            'description' => $noticeAdminDto->description,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => Auth::user()->id,
        ]);
    }
    public function update(Notice $notice, NoticeAdminDto $noticeAdminDto): Notice | bool
    {
        return tap($notice)->update([
            'title' => $noticeAdminDto->title,
            'date' => $noticeAdminDto->date,
            'description' => $noticeAdminDto->description,
            'can_show_on_admin' => $noticeAdminDto->can_show_on_admin,
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Auth::user()->id,
        ]);
    }
    public function delete(Notice $notice)
    {
        return tap($notice)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }
    public function collectionDelete(array $ids)
    {
        $numericIds = array_map('intval', array_filter($ids, 'is_numeric'));
        Notice::whereIn('id', $numericIds)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
            'deleted_by' => Auth::user()->id,
        ]);
    }

    public function toggleCanShowOnAdmin(Notice $notice): void
    {
        $canShowOnAdmin = !$notice->can_show_on_admin;

        $notice->update([
            'can_show_on_admin' => $canShowOnAdmin,
            'updated_by' => Auth::user()->id,
            'updated_at' => now(),
        ]);
    }

    public function storeNoticeWard(Notice $notice, array $wards): void
    {
        $notice->wards()->delete();
        $wardData = array_map(fn($wardId) => ['ward' => $wardId], $wards);
        $notice->wards()->createMany($wardData);
    }

    public function deleteNoticeWards(Notice $notice)
    {
        $notice->wards()?->delete();
    }
}
