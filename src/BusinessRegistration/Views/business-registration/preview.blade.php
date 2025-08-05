@php
    $isCustomer = Auth::guard('customer')->check();
    $layoutComponent = $isCustomer ? 'layout.customer-app' : 'layout.app';
    $header = $isCustomer
        ? 'Business registration'
        : __('businessregistration::businessregistration.business_registration_details');
@endphp

<x-dynamic-component :component="$layoutComponent" :header="$header">
    <livewire:business_registration.business_registration_preview :$businessRegistration />
    </x-layout.app>
