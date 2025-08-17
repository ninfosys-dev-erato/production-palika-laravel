<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('tokentracking::tokentracking.token_management_system') }}</span>
</li>
{{-- <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.searchToken.*') ? 'active' : '' }}">
    <a href="{{ route('admin.searchToken.searchToken') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-buildings"></i>
        <div data-i18n="Tasks">{{ __('tokentracking::tokentracking.search') }}</div>
    </a>
</li> --}}
@perm('tok_token access')
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.register_tokens.*') ? 'active' : '' }}">
        <a href="{{ route('admin.register_tokens.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-buildings"></i>
            <div data-i18n="Tasks">{{ __('tokentracking::tokentracking.register_token') }}</div>
        </a>
    </li>
@endperm
@perm('tok_token_feedback access')
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.token_feedbacks.*') ? 'active' : '' }}">
        <a href="{{ route('admin.token_feedbacks.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-buildings"></i>
            <div data-i18n="Tasks">{{ __('tokentracking::tokentracking.token_feedback') }}</div>
        </a>
    </li>
@endperm
@perm('tok_token_report access')
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.tokenReport.report') ? 'active' : '' }}">
        <a href="{{ route('admin.tokenReport.report') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-buildings"></i>
            <div data-i18n="Tasks">{{ __('tokentracking::tokentracking.token_report') }}</div>
        </a>
    </li>
@endperm
