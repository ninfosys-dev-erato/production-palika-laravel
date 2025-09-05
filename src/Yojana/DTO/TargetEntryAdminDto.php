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
        total_physical_progress: $targetEntry->total_physical_progress ?? 0,
        total_financial_progress: $targetEntry->total_financial_progress ?? 0,
        last_year_physical_progress: $targetEntry->last_year_physical_progress ?? 0,
        last_year_financial_progress: $targetEntry->last_year_financial_progress ?? 0,
        total_physical_goals: $targetEntry->total_physical_goals ?? 0,
        total_financial_goals: $targetEntry->total_financial_goals ?? 0,
        first_quarter_physical_progress: $targetEntry->first_quarter_physical_progress ?? 0,
        first_quarter_financial_progress: $targetEntry->first_quarter_financial_progress ?? 0,
        second_quarter_physical_progress: $targetEntry->second_quarter_physical_progress ?? 0,
        second_quarter_financial_progress: $targetEntry->second_quarter_financial_progress ?? 0,
        third_quarter_physical_progress: $targetEntry->third_quarter_physical_progress ?? 0,
        third_quarter_financial_progress: $targetEntry->third_quarter_financial_progress ?? 0,
        plan_id: $targetEntry->plan_id
    );
}
}
