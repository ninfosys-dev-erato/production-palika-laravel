<?php

namespace Src\Yojana\DTO;


use Src\Yojana\Models\CostEstimationConfiguration;

class CostEstimationConfigurationAdminDto
{
    public function __construct(
        public string $cost_estimation_id,
        public string $configuration,
        public string $operation_type,
        public string $rate,
        public string $amount,
    ) {}

    public static function fromLiveWireModel(CostEstimationConfiguration $costEstimationConfiguration): CostEstimationConfigurationAdminDto
    {
        return new self(
            cost_estimation_id: $costEstimationConfiguration->cost_estimation_id,
            configuration: $costEstimationConfiguration->configuration,
            operation_type: $costEstimationConfiguration->operation_type,
            rate: $costEstimationConfiguration->rate,
            amount: $costEstimationConfiguration->amount,

        );
    }

    public static function fromArrayData(array $data): self
    {
        return new self(
            cost_estimation_id: $data['cost_estimation_id'],
            configuration: $data['configuration'],
            operation_type: $data['operation_type'],
            rate: $data['rate'],
            amount: $data['amount'],
        );
    }


}
