<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\Configuration;

class ConfigurationAdminDto
{
    public function __construct(
        public string $title,
        public string $amount,
        public int $rate,
        public string $type_id,
        public ?bool $use_in_cost_estimation,
        public ?bool $use_in_payment
    ) {}

    public static function fromLiveWireModel(Configuration $configuration): ConfigurationAdminDto
    {
        return new self(
            title: $configuration->title,
            amount: $configuration->amount,
            rate: $configuration->rate,
            type_id: $configuration->type_id,
            use_in_cost_estimation: $configuration->use_in_cost_estimation ?? false,
            use_in_payment: $configuration->use_in_payment ?? false
        );
    }
}
