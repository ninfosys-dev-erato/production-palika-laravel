<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Enums\ImplementationMethods;
use Src\Yojana\Models\ImplementationMethod;

class ImplementationMethodAdminDto
{
    public function __construct(
        public string $title,
        public string $code,
        public ImplementationMethods $model
    ) {}

    public static function fromLiveWireModel(ImplementationMethod $implementationMethod): ImplementationMethodAdminDto
    {
        return new self(
            title: $implementationMethod->title,
            code: $implementationMethod->code,
            model: $implementationMethod->model
        );
    }
}
