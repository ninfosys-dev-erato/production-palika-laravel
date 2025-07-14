<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Src\CustomerKyc\Model\CustomerKycVerificationLog;
use Src\Customers\Enums\DocumentTypeEnum;
use Src\Customers\Enums\GenderEnum;
use Src\Customers\Enums\KycStatusEnum;
use Src\Customers\Enums\LanguagePreferenceEnum;
use Src\Customers\Models\Customer;
use Src\Recommendation\Enums\RecommendationStatusEnum;
use Src\Recommendation\Models\ApplyRecommendation;
use Src\Recommendation\Models\RecommendationLog;

class RecommendationStatusLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected mixed $applyRecommendationId;
    protected array $detailOriginal;
    protected array $detailChanges;

    protected array $ignoreFields = ['created_at', 'updated_at','data'];
    protected array $skipComparisonIfSame = ['bill'];

    public function __construct(ApplyRecommendation $applyRecommendation, array $originalAttributes, array $newAttributes)
    {
        $this->applyRecommendationId = $applyRecommendation->id;
        $this->detailOriginal = $originalAttributes;
        $this->detailChanges = $newAttributes;
    }

    public function handle(): void
    {
        $changes = array_merge(
            $this->detectChanges($this->detailOriginal, $this->detailChanges),
        );

        $remark = "सिफारिस अपडेट गरियो" . "\n" . $this->generateRemarks($changes);

        RecommendationLog::create([
            'apply_recommendation_id' => $this->applyRecommendationId,
            'old_status' => $this->detailOriginal['status'],
            'new_status' => $this->detailChanges['status'],
            'old_details' => json_encode($this->detailOriginal),
            'new_details' => json_encode($this->detailChanges),
            'remarks' => $remark,
        ]);
    }

    protected function detectChanges(array $original, array $changes): array
    {
        $detectedChanges = [];

        foreach ($changes as $key => $newValue) {
            if ($this->shouldSkipField($key, $original, $newValue)) {
                continue;
            }

            $originalValue = $this->getOriginalValue($original, $key);

            if ((string) $originalValue !== (string) $newValue) {
                $detectedChanges[] = [
                    'field' => $key,
                    'old' => $originalValue,
                    'new' => $newValue,
                ];
            }
        }

        return $detectedChanges;
    }

    protected function shouldSkipField($key, $original, $newValue): bool
    {
        if (in_array($key, $this->ignoreFields)) {
            return true;
        }

        return in_array($key, $this->skipComparisonIfSame) && ($original[$key] === $newValue);
    }

    protected function getOriginalValue(array $original, string $key): mixed
    {
        return match (true) {
            $key === 'status' && $original[$key] instanceof RecommendationStatusEnum => $original[$key]->value,
            default => $original[$key]
        };
    }

    protected function generateRemarks(array $changes): string
    {
        return collect($changes)->map(function ($change) {
            return "→ " . ucfirst(str_replace('_', ' ', $change['field'])) . ": changed from '" . $change['old'] . "' to '" . $change['new'] . "'";
        })->implode("\n");
    }
}
