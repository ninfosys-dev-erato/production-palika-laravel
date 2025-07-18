@component('mail::message')
# Registration Update

Congratulations **{{ $name }}**!  

Your organization registration has been **approved**. You can now log in to the business portal and manage your organization.

@component('mail::button', ['url' => $appUrl . '/login'])
Login to Business Portal
@endcomponent

Thanks,<br>
E-Palika
@endcomponent
