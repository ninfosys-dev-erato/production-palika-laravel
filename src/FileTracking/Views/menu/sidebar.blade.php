<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('filetracking::filetracking.patrachar') }}</span>
</li>

{{-- <li class="menu-item"> --}}
{{--    <a href="#" class="menu-link"> --}}
{{--        <i class="menu-icon tf-icons bx bx-pencil"></i> --}}
{{--        <div data-i18n="FileRecords">{{ __('filetracking::filetracking.create_a_new_letter') }}</div> --}}
{{--    </a> --}}
{{-- </li> --}}
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.file_records.compose') ? 'active' : '' }}">
    <a href="{{ route('admin.file_records.compose') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-comment-add"></i>
        <div data-i18n="FileRecords">{{ __('filetracking::filetracking.compose') }}</div>
    </a>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.file_records.manage', 'admin.file_records.inbox') ? 'active' : '' }}">
    <a href="{{ route('admin.file_records.manage') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-chat"></i>
        <div data-i18n="FileRecords">{{ __('filetracking::filetracking.inbox') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.file_records.starred') ? 'active' : '' }}">
    <a href="{{ route('admin.file_records.starred') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-star"></i>
        <div data-i18n="FileRecords">{{ __('filetracking::filetracking.starred') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.file_records.sent') ? 'active' : '' }}">
    <a href="{{ route('admin.file_records.sent') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-send"></i>
        <div data-i18n="FileRecords">{{ __('filetracking::filetracking.sent') }}</div>
    </a>
</li>
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('filetracking::filetracking.file_tracking') }}</span>
</li>


<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.file_records.index') ? 'active' : '' }}">
    <a href="{{ route('admin.file_records.index') }}" class="menu-link">
        <div data-i18n="FileRecords">{{ __('filetracking::filetracking.file_records') }}</div>
    </a>
</li>

<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.file_record_logs.*') ? 'active' : '' }}">
    <a href="{{ route('admin.file_record_logs.index') }}" class="menu-link">
        <div data-i18n="FileRecordLogs">{{ __('filetracking::filetracking.file_record_logs') }}</div>
    </a>
</li>
<li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.file_record_notifiees.*') ? 'active' : '' }}">
    <a href="{{ route('admin.file_record_notifiees.index') }}" class="menu-link">
        <div data-i18n="FileRecordNotifiees">{{ __('filetracking::filetracking.file_record_notifiees') }}</div>
    </a>
</li>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.patrachar.form-template.index') ? 'active' : '' }}">
    <a href="{{ route('admin.patrachar.form-template.index') }}" class="menu-link">
        <div data-i18n="FileRecordNotifiees">{{ __('filetracking::filetracking.form_template') }}</div>
    </a>
</li>
