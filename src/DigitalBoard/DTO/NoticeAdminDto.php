<?php

namespace Src\DigitalBoard\DTO;

use Src\DigitalBoard\Models\Notice;

class NoticeAdminDto
{
    public function __construct(
        public string $title,
        public string $date,
        public bool $can_show_on_admin,
        public string $description,
        public string $file
    ) {}

    public static function fromLiveWireModel(Notice $notice): NoticeAdminDto
    {
        return new self(
            title: $notice->title,
            date: $notice->date,
            can_show_on_admin: $notice->can_show_on_admin,
            description: $notice->description,
            file: $notice->file
        );
    }
}
