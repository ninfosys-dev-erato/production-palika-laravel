<?php
$locale = app()->getLocale();
$publicSettings = \Src\Settings\Models\SettingGroup::select(
    'slug', // Select any other necessary columns
    $locale === 'en' ? 'group_name' : 'group_name_ne as group_name', // Conditionally select the column based on the locale
)
    ->where('is_public', true)
    ->whereNull('deleted_at')
    ->whereNull('deleted_by')
    ->with('settings')
    ->get();
$privateSettings = \Src\Settings\Models\SettingGroup::select(
    'slug', // Select any other necessary columns
    $locale === 'en' ? 'group_name' : 'group_name_ne as group_name', // Conditionally select the column based on the locale
)
    ->where('is_public', false)
    ->whereNull('deleted_at')
    ->whereNull('deleted_by')
    ->with('settings')
    ->get();
?>
<li
    class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.settings.*', 'admin.setting_groups.*', 'admin.setting.*')
        ? 'active'
        : '' }}">
    <a href="{{ route('admin.setting_groups.index') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bxs-file"></i>
        <div data-i18n="Setting Group">{{ __('settings::settings.setting_group') }}</div>
    </a>
</li>
@if ($publicSettings->count() > 0)
    <li class="menu-item" style="">
        <a href="#" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-checkbox-square"></i>
            <div data-i18n="{{ __('settings::settings.public_settings') }}">{{ __('settings::settings.public_settings') }} </div>
        </a>
        <ul class="menu-sub">
            @foreach ($publicSettings as $key => $settings)
                <li class="menu-item ">
                    <a href="{{ route('admin.settings.manage', ['slug' => $settings->slug]) }}" class="menu-link">
                        <div data-i18n="{{ $settings->group_name }}">{{ $settings->group_name }}</div>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endif

@if ($privateSettings->count() > 0)
    <li class="menu-item" style="">
        <a href="#" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-checkbox-square"></i>
            <div data-i18n="{{ __('settings::settings.private_settings') }}">{{ __('settings::settings.private_settings') }} </div>
        </a>
        <ul class="menu-sub">
            @foreach ($privateSettings as $key => $settings)
                <li class="menu-item ">
                    <a href="{{ route('admin.settings.manage', ['slug' => $settings->slug]) }}" class="menu-link">
                        <div data-i18n="{{ $settings->group_name }}">{{ $settings->group_name }}</div>
                    </a>
                </li>
            @endforeach
        </ul>
    </li>
@endif
