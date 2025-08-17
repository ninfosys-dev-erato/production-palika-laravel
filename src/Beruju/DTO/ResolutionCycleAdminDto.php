<?php

namespace Src\Beruju\DTO;

use Src\Beruju\Models\ResolutionCycle;

class ResolutionCycleAdminDto
{
    public function __construct(
        public int $beruju_id,
        public int $incharge_id,
        public ?string $status = 'active',
        public ?string $remarks = null,
        public ?string $completed_at = null,
    ) {}

    public static function fromLiveWireModel(ResolutionCycle $resolutionCycle): ResolutionCycleAdminDto
    {
        return new self(
            beruju_id: $resolutionCycle->beruju_id,
            incharge_id: $resolutionCycle->incharge_id,
            status: $resolutionCycle->status,
            remarks: $resolutionCycle->remarks,
            completed_at: $resolutionCycle->completed_at,
        );
    }

    public static function fromRequest(array $data): ResolutionCycleAdminDto
    {
        return new self(
            beruju_id: $data['beruju_id'],
            incharge_id: $data['incharge_id'],
            status: $data['status'],
            remarks: $data['remarks'],
        );
    }

    public static function fromModel(ResolutionCycle $resolutionCycle): ResolutionCycleAdminDto
    {
        return new self(
            beruju_id: $resolutionCycle->beruju_id,
            incharge_id: $resolutionCycle->incharge_id,
            status: $resolutionCycle->status,
            remarks: $resolutionCycle->remarks,
        );
    }

    public function toArray(): array
    {
        return [
            'beruju_id' => $this->beruju_id,
            'incharge_id' => $this->incharge_id,
            'status' => $this->status,
            'remarks' => $this->remarks,
        ];
    }
}
