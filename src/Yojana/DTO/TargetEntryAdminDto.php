<?php

namespace Src\Yojana\DTO;

use Src\Yojana\Models\TargetEntry;

class TargetEntryAdminDto
{
   public function __construct(
        public string $progress_indicator_id,
        public string $total_physical_progress,
        public string $total_financial_progress,
        public string $last_year_physical_progress,
        public string $last_year_financial_progress,
        public string $total_physical_goals,
        public string $total_financial_goals,
        public string $first_quarter_physical_progress,
        public string $first_quarter_financial_progress,
        public string $second_quarter_physical_progress,
        public string $second_quarter_financial_progress,
        public string $third_quarter_physical_progress,
        public string $third_quarter_financial_progress,
        public string $plan_id
    ){}

public static function fromLiveWireModel(TargetEntry $targetEntry):TargetEntryAdminDto{
    return new self(
        progress_indicator_id: $targetEntry->progress_indicator_id,
        total_physical_progress: $targetEntry->total_physical_progress,
        total_financial_progress: $targetEntry->total_financial_progress,
        last_year_physical_progress: $targetEntry->last_year_physical_progress,
        last_year_financial_progress: $targetEntry->last_year_financial_progress,
        total_physical_goals: $targetEntry->total_physical_goals,
        total_financial_goals: $targetEntry->total_financial_goals,
        first_quarter_physical_progress: $targetEntry->first_quarter_physical_progress,
        first_quarter_financial_progress: $targetEntry->first_quarter_financial_progress,
        second_quarter_physical_progress: $targetEntry->second_quarter_physical_progress,
        second_quarter_financial_progress: $targetEntry->second_quarter_financial_progress,
        third_quarter_physical_progress: $targetEntry->third_quarter_physical_progress,
        third_quarter_financial_progress: $targetEntry->third_quarter_financial_progress,
        plan_id: $targetEntry->plan_id
    );
}
}
