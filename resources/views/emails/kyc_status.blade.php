@component('mail::message')
# {{ __("Regarding KYC Verification Status") }}

{{ __("Dear customer,") }}

@if ($status === 'approved')
    {{ __("Your KYC has been approved.") }}
@elseif ($status === 'rejected')
    {{ __("Your KYC has been rejected.") }}
    {{ __("Reason:") }} {{ $rejectionReasons }}
@else
    {{ __("Your KYC has been submitted successfully. Our team is reviewing your information and will update you once the verification is complete.") }}
@endif

{{ __("Thank you for using our services and for your trust in us.") }}

Regards,  
{{ __('E-Palika') }}
@endcomponent