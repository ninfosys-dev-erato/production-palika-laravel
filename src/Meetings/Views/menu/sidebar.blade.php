<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('Meeting') }}</span>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.meetings.index') ? 'active' : '' }}">
    <a href="{{ route('admin.meetings.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-tv"></i>
        <div data-i18n="Meeting">{{ __('Meeting') }}</div>
    </a>
</li>
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('Committee') }}</span>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.committee-types.index') ? 'active' : '' }}">
    <a href="{{ route('admin.committee-types.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bell-plus"></i>
        <div data-i18n="CommitteeTypes">{{ __('Committee Type') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.committees.index') ? 'active' : '' }}">
    <a href="{{ route('admin.committees.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-building"></i>
        <div data-i18n="Committee">{{ __('Committee') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.committee-members.index') ? 'active' : '' }}">
    <a href="{{ route('admin.committee-members.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-group"></i>
        <div data-i18n="CommitteeMember">{{ __('Committee Member') }}</div>
    </a>
</li>
