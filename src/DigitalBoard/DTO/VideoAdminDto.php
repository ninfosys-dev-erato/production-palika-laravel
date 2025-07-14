<?php

namespace Src\DigitalBoard\DTO;

use Src\DigitalBoard\Models\Video;

class VideoAdminDto
{
    public function __construct(
        public string $title,
        public ?string $url,
        public ?string $file,
        public bool $can_show_on_admin,
        public bool $is_private,
    ) {}

    public static function fromLiveWireModel(Video $video): VideoAdminDto
    {
        return new self(
            title: $video->title,
            url: $video->url ?? null,
            file: $video->file ?? null,
            can_show_on_admin: $video->can_show_on_admin,
            is_private: $video->is_private
        );
    }
}
