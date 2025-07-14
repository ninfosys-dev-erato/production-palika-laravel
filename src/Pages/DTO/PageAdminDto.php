<?php

namespace Src\Pages\DTO;

use Src\Pages\Models\Page;

class PageAdminDto
{
   public function __construct(
        public ?string $slug,
        public string $title,
        public string $content
    ){}

public static function fromLiveWireModel(Page $page):PageAdminDto{
    return new self(
        slug: $page->slug,
        title: $page->title,
        content: $page->content
    );
}
}
