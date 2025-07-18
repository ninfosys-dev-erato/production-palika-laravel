@component('mail::message')
# {{ __("Regarding Grievance Status") }}

{{ __('Dear Customer,') }}

@if ($status === 'closed')
    {{ __("We are pleased to inform you that your grievance has been successfully closed. After reviewing the issue, we have taken appropriate actions, and no further steps are required on your part. If you have any questions or need further assistance, please feel free to reach out.") }}
@elseif ($status === 'investigating')
    {{ __("Our team is currently investigating the issue, and we will notify you shortly with the final resolution. We appreciate your patience and cooperation during this process.") }}
@elseif ($status === 'submit')
    {{ __("Thank you for submitting your grievance. Our team is reviewing your concerns with priority.") }}
@endif

{{ __("For your reference, your grievance tracking token is:") }} {{ $token }}  
{{ __("Please keep this token handy for any future communications or to track the status of your grievance.") }}

{{ __("Thank you for using our services and for your trust in us.") }}

Regards,  
{{ __('E-Palika') }}
@endcomponent
