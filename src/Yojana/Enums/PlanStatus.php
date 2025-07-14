<?php

namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum PlanStatus: string implements EnumInterface
{
    case PlanEntry = 'plan_entry';
    case ProjectInchargeAppointed = 'project_incharge_appointed';
    case CostEstimationEntry = 'cost_estimation_entry';

    case TargetEntry = 'target_entry';
    case CostEstimationReview = 'cost_estimation_review';
    case CostEstimationApproved = 'cost_estimation_approved';
    case ImplementationAgencyAppointed = 'implementation_agency_appointed';
    case AgreementCompleted = 'agreement_completed';
    case AdvancePaymentCompleted = 'advance_payment_completed';
    case EvaluationCompleted = 'evaluation_completed';

    case Completed = 'completed'; // used in DB

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }

    public static function getValuesWithLabels(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[] = [
                'value' => $value,
                'label' => $value->label(),
            ];
        }

        return $valuesWithLabels;
    }

    public static function getLabel(EnumInterface $value): string
    {
        return match ($value) {
            self::PlanEntry => __('yojana::yojana.plan_entry'),
            self::ProjectInchargeAppointed => __('yojana::yojana.project_incharge_appointed'),
            self::CostEstimationEntry => __('yojana::yojana.cost_estimation_entry'),
            self::TargetEntry => __('yojana::yojana.target_entry'),
            self::CostEstimationReview => __('yojana::yojana.cost_estimation_review'),
            self::CostEstimationApproved => __('yojana::yojana.cost_estimation_approved'),
            self::ImplementationAgencyAppointed => __('yojana::yojana.implementation_agency_appointed'),
            self::AgreementCompleted => __('yojana::yojana.agreement_completed'),
            self::AdvancePaymentCompleted => __('yojana::yojana.advance_payment_completed'),
            self::EvaluationCompleted => __('yojana::yojana.evaluation_completed'),
            self::Completed => __('yojana::yojana.completed'),
        };
    }
}
