@php

    use Illuminate\Support\Facades\Cache;
    $service = new \Src\Recommendation\Services\RecommendationAdminService();
    $categories = Cache::remember('recommendation_category_tree', 60, function () use ($service) {
        return $service->categoryTree();
    });
    $customer = Src\Customers\Models\Customer::where('id', Auth::guard('customer')->id())
        ->with('kyc')
        ->first();
    $businessRenew = Src\BusinessRegistration\Models\BusinessRenewal::where(
        'created_by',
        Auth::guard('customer')->id(),
    )->get();

    $recommendationActive = \Illuminate\Support\Facades\Route::is([
        'customer.recommendations.apply-recommendation.index',
        'customer.recommendations.apply-recommendation.create',
    ]);

@endphp
<ul class="menu-inner py-1">

    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.dashboard') ? 'active' : '' }}">
        <a href="{{ route('customer.dashboard') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-home-circle"></i>
            <div data-i18n="Analytics">{{ __('Dashboard') }}</div>
        </a>
    </li>
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.kyc.index') ? 'active' : '' }}">
        <a href="{{ route('customer.kyc.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-user"></i>
            <div data-i18n="Form">{{ __('Customer Detail') }}</div>
        </a>
    </li>

    @if (!empty($customer->kyc_verified_at))
        @if (isModuleEnabled('grievance'))
            <li
                class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.grievance.index') ? 'active' : '' }}">
                <a href="{{ route('customer.grievance.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-user-circle"></i>
                    <div data-i18n="Form">{{ __('Grievance') }}</div>
                </a>
            </li>
        @endif

        @if (isModuleEnabled('recommendation'))
            <li
                class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.recommendations.apply-recommendation.index') ? 'active' : '' }}">
                <a href="{{ route('customer.recommendations.apply-recommendation.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-notepad"></i>
                    <div data-i18n="Form">{{ __('Recommendation') }}</div>
                </a>
            </li>
        @endif
        @if (isModuleEnabled('business_registration'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">{{ __('Business Registration') }}</span>
            </li>
            <li
                class="menu-item  {{ \Illuminate\Support\Facades\Route::is('customer.business-registration.business-registration.*') ? 'open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">{{ __('Business Registration') }}</div>
                </a>
                <ul class="menu-sub">

                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.business-registration.business-registration.index') ? 'active' : '' }}">
                        <a href="{{ route('customer.business-registration.business-registration.index') }}"
                            class="menu-link">
                            <i class="menu-icon tf-icons  bx bx-briefcase"></i>
                            <div data-i18n="Form">{{ __('Business Registration') }}</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif
        @if ($businessRenew->isNotEmpty())
            <li
                class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.business-registration.renewals.index') ? 'active' : '' }}">
                <a href="{{ route('customer.business-registration.renewals.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-briefcase"></i>
                    <div data-i18n="Form">{{ __('Business Renewal') }}</div>
                </a>
            </li>
        @endif
        @if (isModuleEnabled('ebps'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">{{ __('Ebps') }}</span>
            </li>
            <li class="menu-item  {{ \Illuminate\Support\Facades\Route::is('customer.ebps.*') ? 'open' : '' }}">
                <a href="#" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">{{ __('Ebps') }}</div>
                </a>
                <ul class="menu-sub">

                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.ebps.apply.*') ? 'active' : '' }}">
                        <a href="{{ route('customer.ebps.apply.map-apply.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div data-i18n="FiscalYear">{{ __('Map Apply') }}</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ \Illuminate\Support\Facades\Route::is('customer.ebps.building-registrations.*') ? 'active' : '' }}">
                        <a href="{{ route('customer.ebps.building-registrations.index') }}" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-calendar"></i>
                            <div data-i18n="FiscalYear">{{ __('ebps::ebps.building_registration_application') }}</div>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

    @endif

    @if ($recommendationActive)
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">{{ __('Apply') . ' ' . __('Recommendation') }}</span>
        </li>
        @foreach ($categories as $category)
            @if ($category['recommendations_count'] > 0)
                <li class="menu-item" style="">
                    <a href="#" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-checkbox-square"></i>
                        <div data-i18n="{{ $category['title'] }}">{{ $category['title'] }} </div>
                    </a>
                    @foreach ($category['recommendations'] as $recommendation)
                        <ul class="menu-sub">
                            <li class="menu-item ">
                                <a href="{{ route('customer.recommendations.apply-recommendation.create', ['recommendation' => $recommendation['id']]) }}"
                                    class="menu-link">
                                    <div data-i18n="{{ $recommendation['title'] }}">{{ $recommendation['title'] }}
                                    </div>
                                </a>
                            </li>
                        </ul>
                    @endforeach
                </li>
            @endif
        @endforeach
    @endif

</ul>
