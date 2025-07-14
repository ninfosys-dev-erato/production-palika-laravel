<?php

namespace Src\Downloads\DTO;

use Src\Downloads\Models\Download;

class DownloadAdminDto
{
   public function __construct(
        public string $title,
        public string $title_en,
        public ?array $files,
        public string $status,
        public int $order
    ){}

public static function fromLiveWireModel(Download $download):DownloadAdminDto{
    return new self(
        title: $download->title,
        title_en: $download->title_en,
        files: $download->files,
        status: $download->status,
        order: $download->order
    );
}
}
