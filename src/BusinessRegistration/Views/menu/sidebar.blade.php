<?php
use Illuminate\Support\Facades\Cache;
use Src\BusinessRegistration\Models\RegistrationType;
use Src\BusinessRegistration\Enums\BusinessRegistrationType;
use Src\BusinessRegistration\Enums\RegistrationCategoryEnum;

$registrationTypes = Cache::remember('registration_types_by_enum', 60, function () {
    return RegistrationType::select('id', 'title', 'registration_category_enum', 'action', 'status')->where('status', true)->get();
});
?>




<li class="menu-header small text-uppercase">
    <span
        class="menu-header-text">{{ __('businessregistration::businessregistration.business_registration__renewal') }}</span>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.business-registration.*') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.business-registration.index', ['type' => BusinessRegistrationType::REGISTRATION]) }}"
        class="menu-link">
        <i class="menu-icon tf-icons bx bx-video"></i>
        <div data-i18n="Videos">{{ __('businessregistration::businessregistration.business_registration') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-deregistration.*') ? 'active' : '' }}">

    <a href="{{ route('admin.business-deregistration.index', ['type' => BusinessRegistrationType::DEREGISTRATION]) }}"
        class="menu-link">
        <i class="menu-icon tf-icons bx bx-video"></i>
        <div data-i18n="Videos">{{ __('businessregistration::businessregistration.deregister_business') }}</div>
    </a>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.renewals.*') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.renewals.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-video"></i>
        <div data-i18n="Videos">{{ __('businessregistration::businessregistration.business_renewals') }}</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('businessregistration::businessregistration.apply_for_registration') }}</span>
</li>


@foreach (RegistrationCategoryEnum::getForWeb() as $value => $label)
    @php
        $types = $registrationTypes->filter(
            fn($type) => $type->registration_category_enum === $value &&
                $type->action === BusinessRegistrationType::REGISTRATION,
        );
    @endphp

    @if ($types->isNotEmpty())
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-checkbox-square"></i>
                <div data-i18n="{{ $value }}">{{ $label }}</div>
            </a>
            <ul class="menu-sub">
                @foreach ($types as $type)
                    <li class="menu-item">
                        <a href="{{ route('admin.business-registration.business-registration.create', [
                            'registration' => $type->id,
                            'type' => BusinessRegistrationType::REGISTRATION,
                        ]) }}"
                            class="menu-link">
                            <div data-i18n="{{ $type->title }}">{{ __($type->title) }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endforeach


{{-- @foreach ($categories as $category)
    @if (count($category->registrationTypes) > 0)
        <li class="menu-item">
            <a href="#" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-checkbox-square"></i>
                <div data-i18n="{{ $category->title }}">{{ __($category->title) }}</div>
            </a>
            <ul class="menu-sub">
                @foreach ($category->registrationTypes as $type)
                    <li class="menu-item">
                        <a href="{{ route('admin.business-registration.business-registration.create', [
                            'registration' => $type->id,
                            'type' => BusinessRegistrationType::REGISTRATION,
                        ]) }}"
                            class="menu-link">
                            <div data-i18n="{{ $type->title }}">{{ __($type->title) }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endforeach --}}


<li class="menu-header small text-uppercase">
    <span
        class="menu-header-text">{{ __('businessregistration::businessregistration.business_registration_settings') }}</span>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.business-nature.*') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.business-nature.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="BusinessNature">{{ __('businessregistration::businessregistration.business_nature') }}</div>
    </a>
</li>

{{-- <li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.registration-category.*') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.registration-category.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-category"></i>
        <div data-i18n="RegistrationCategory">
            {{ __('businessregistration::businessregistration.registration_categories') }}</div>
    </a>
</li> --}}

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.registration-types.*') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.registration-types.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="RegistrationType">{{ __('businessregistration::businessregistration.registration_types') }}
        </div>
    </a>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.form.*') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.form-template.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="RegistrationType">{{ __('businessregistration::businessregistration.form_template') }}</div>
    </a>
</li>


<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('Report') }}</span>
</li>

<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.report') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.report') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="RegistrationType">{{ __('Report') }}</div>
    </a>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.business-registration.renewal-report') ? 'active' : '' }}">
    <a href="{{ route('admin.business-registration.renewal-report') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-file"></i>
        <div data-i18n="RegistrationType">{{ __('businessregistration::businessregistration.renewal_report') }}</div>
    </a>
</li>
