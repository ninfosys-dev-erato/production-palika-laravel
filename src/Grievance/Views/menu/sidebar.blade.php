<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('grievance::grievance.grievance') }}</span>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grievance.grievanceType.*') ? 'active' : '' }}">
    <a href="{{ route('admin.grievance.grievanceType.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-git-branch"></i>
        <div data-i18n="FiscalYear">{{ __('grievance::grievance.grievance_type') }}</div>
    </a>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grievance.grievanceDetail.index', 'admin.grievance.grievanceDetail.show', 'admin.grievance.create') ? 'active' : '' }}">
    <a href="{{ route('admin.grievance.grievanceDetail.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        <div data-i18n="FiscalYear">{{ __('grievance::grievance.grievance_detail') }}</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('grievance::grievance.report') }}</span>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grievance.grievanceDetail.report') ? 'active' : '' }}">
    <a href="{{ route('admin.grievance.grievanceDetail.report') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-dock-top"></i>
        <div data-i18n="Account Settings">{{ __('grievance::grievance.grievance_report') }}</div>
    </a>

</li>
{{-- <li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grievance.grievanceDetail.appliedGrievaceReport') ? 'active' : '' }}">
    <a href="{{ route('admin.grievance.grievanceDetail.appliedGrievaceReport') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-user-circle"></i>
        <div data-i18n="FiscalYear">{{ __('grievance::grievance.received_grievance_report') }}</div>
    </a>
</li> --}}


<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('grievance::grievance.setting') }}</span>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.grievance.grievanceDetail.notification') ? 'active' : '' }}">
    <a href="{{ route('admin.grievance.grievanceDetail.notification') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-cog"></i>
        <div data-i18n="Account Settings">{{ __('grievance::grievance.notification_setting') }}</div>
    </a>
</li>
