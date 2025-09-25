<?php


namespace Src\Yojana\Enums;

use App\Contracts\EnumInterface;

enum LetterTypes :string implements EnumInterface
{

    case SealedFinancialProposalOpeningLetter = 'sealed_financial';
    case TimeExtension = 'time_extension';
    case Payment = 'payment';
    case AdvancePayment = 'advance';
    case AccountOperationRecommendation = 'account_operation_letter';
    case AccountClosureRecommendation = 'account_closure_letter';
    case RegistrationCertificate = 'registration_certificate';
    case WorkOrder = 'work_order';
    case ProgramApprovalAndInformationLetter = 'program_approval';
    case VATRegistrationCertificate = 'vat_cert';
    case LetterOfIntentPublicationNotice = 'intent_notice';
    case RateQuotationSubmission = 'rate-quotation';
    case Agreement = 'agreement';
    case PaymentRecommendationLetter = 'payment_recommendation';
    case PlanHandoverLetter = 'plan_handover';

    public function label(): string
    {
        return self::getLabel($this);
    }

    public static function getLabel(EnumInterface $value): string
    {
        return match ($value) {
            self::SealedFinancialProposalOpeningLetter => __('yojana::yojana.sealed_financial_proposal_opening_letter'),
            self::TimeExtension => __('yojana::yojana.time_extension'),
            self::Payment => __('yojana::yojana.payment'),
            self::AdvancePayment => __('yojana::yojana.advance_payment'),
            self::AccountOperationRecommendation => __('yojana::yojana.account_operation_recommendation'),
            self::AccountClosureRecommendation => __('yojana::yojana.account_closure_recommendation'),
            self::RegistrationCertificate => __('yojana::yojana.registration_certificate'),
            self::WorkOrder => __('yojana::yojana.work_order'),
            self::ProgramApprovalAndInformationLetter => __('yojana::yojana.program_approval_and_information_letter'),
            self::VATRegistrationCertificate => __('yojana::yojana.vat_registration_certificate'),
            self::LetterOfIntentPublicationNotice => __('yojana::yojana.letter_of_intent_publication_notice'),
            self::Agreement => __('yojana::yojana.agreement'),
            self::RateQuotationSubmission => __('yojana::yojana.rate_quotation_submission'),
            self::PaymentRecommendationLetter => __('yojana::yojana.payment_recommendation_letter'),
            self::PlanHandoverLetter => __('yojana::yojana.plan_handover_letter'),
        };









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

    public static function getForWeb(): array
    {
        $valuesWithLabels = [];

        foreach (self::cases() as $value) {
            $valuesWithLabels[$value->value] = $value->label();
        }

        return $valuesWithLabels;
    }
}
