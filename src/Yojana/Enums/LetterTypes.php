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
    case AgreementInstruction = 'agreement_instruction';
    case AdvancePaymentInstruction = 'advance_payment_instruction';
    case PaymentInstruction = 'payment_instruction';
    case AgreementLetter = 'agreement_letter';
    case PaymentRecommendationLetter = 'payment_recommendation';
    case PlanHandoverLetter = 'plan_handover';
    case TenderApprovalLetter = 'tender_approval';
    case BiddersPaymentLetter = 'bidders_payment';
    case RateSubmissionLetter = 'rate_submission';
    case TenderOpeningForm = 'tender_opening_form';
    case TenderOpeningMinute = 'tender_opening_minute';
    case EvaluationCommitteeMinute = 'evaluation_committee_minute';
    case QuotationApprovalLetter = 'quotation_approval';

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
            self::AgreementInstruction => __('yojana::yojana.agreement_instruction'),
            self::AdvancePaymentInstruction => __('yojana::yojana.advance_payment_instruction'),
            self::PaymentInstruction => __('yojana::yojana.payment_instruction'),
            self::AgreementLetter => __('yojana::yojana.agreement_letter'),
            self::RateQuotationSubmission => __('yojana::yojana.rate_quotation_submission'),
            self::PaymentRecommendationLetter => __('yojana::yojana.payment_recommendation_letter'),
            self::PlanHandoverLetter => __('yojana::yojana.plan_handover_letter'),
            self::TenderApprovalLetter => __('yojana::yojana.tender_approval_letter'),
            self::BiddersPaymentLetter => __('yojana::yojana.bidders_payment_letter'),
            self::RateSubmissionLetter => __('yojana::yojana.rate_submission_letter'),
            self::TenderOpeningForm => __('yojana::yojana.tender_opening_form'),
            self::TenderOpeningMinute => __('yojana::yojana.tender_opening_minute'),
            self::EvaluationCommitteeMinute => __('yojana::yojana.evaluation_committee_minute'),
            self::QuotationApprovalLetter => __('yojana::yojana.quotation_approval_letter'),
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
