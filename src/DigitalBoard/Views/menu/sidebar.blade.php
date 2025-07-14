<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('digitalboard::digitalboard.digital_citizen_board') }}</span>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.digital_board.notices.*') ? 'active' : '' }}">
    <a href="{{ route('admin.digital_board.notices.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-notification"></i>
        <div data-i18n="Notices">{{ __('digitalboard::digitalboard.notices') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.digital_board.videos.*') ? 'active' : '' }}">
    <a href="{{ route('admin.digital_board.videos.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-video"></i>
        <div data-i18n="Videos">{{ __('digitalboard::digitalboard.videos') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.digital_board.programs.*') ? 'active' : '' }}">
    <a href="{{ route('admin.digital_board.programs.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-calendar-event"></i>
        <div data-i18n="Programs">{{ __('digitalboard::digitalboard.programs') }}</div>
    </a>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.digital_board.citizen_charters.*') ? 'active' : '' }}">
    <a href="{{ route('admin.digital_board.citizen_charters.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-book-content"></i>
        <div data-i18n="CitizenCharter">{{ __('digitalboard::digitalboard.citizen_charter') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.digital_board.pop_ups.*') ? 'active' : '' }}">
    <a href="{{ route('admin.digital_board.pop_ups.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-message-alt-dots"></i>
        <div data-i18n="PopUps">{{ __('digitalboard::digitalboard.popup') }}</div>
    </a>
</li>
