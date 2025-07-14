@component('mail::message')
    # Registration Update

    Hello **{{ $name }}**,

    Unfortunately, your organization registration has been **rejected**.

    **Reason:**
    {{ $reason }}

    Please contact support for further details.

    @component('mail::button', ['url' => $appUrl])
        Visit Portal
    @endcomponent

    Thanks,<br>
    E-Palika
@endcomponent
