<?php

namespace Src\Ebps\DTO;

use Src\Ebps\Enums\ApplicationTypeEnum;
use Src\Ebps\Models\Document;

class DocumentAdminDto
{
   public function __construct(
        public ?string $title,
        public ?string $application_type
    ){}

public static function fromLiveWireModel(Document $document):DocumentAdminDto{
    return new self(
        title: $document->title,
        application_type: $document->application_type
    );
}
}
