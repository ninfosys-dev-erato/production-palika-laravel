<div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvasMenu" aria-labelledby="offcanvasBackdropLabel">
    <div class="offcanvas-header border-bottom">
        <div class="flex-column">
            <h5 id="offcanvasBackdropLabel" class="offcanvas-title">{{ __('App List') }}</h5>
            <span class="small">{{ __('Click on the app to redirect') }}</span>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body my-4 mx-0 flex-grow-0">
        <div class="mt-4">
            <div class="list-group list-group-flush">

                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action module-link">
                    <i class="menu-icon tf-icons bx bx-home text-primary"></i>
                    {{ __('Dashboard') }}
                </a>

                @foreach (config('module_menu') as $module)
                    @if (isModuleEnabled($module['module']))
                        @if (empty($module['perm']) || auth()->user()->can($module['perm']))
                            <a href="{{ route($module['route']) }}"
                                class="list-group-item list-group-item-action module-link">
                                <i class="menu-icon tf-icons {{ $module['icon'] }}"></i>
                                {{ __($module['label']) }}
                            </a>
                        @endif
                    @endif
                @endforeach

                @perm('page_access')
                    <a href="{{ route('admin.pages.index') }}" class="list-group-item list-group-item-action">
                        <i class="menu-icon tf-icons bx bx-file text-primary"></i>
                        {{ __('Pages') }}
                    </a>
                @endperm

                @perm('downloads_access')
                    <a href="{{ route('admin.downloads.index') }}" class="list-group-item list-group-item-action">
                        <i class="menu-icon tf-icons bx bx-download text-info"></i>
                        {{ __('Downloads') }}
                    </a>
                @endperm

                @perm('emergency_contact access')
                    <a href="{{ route('admin.emergency-contacts.index') }}" class="list-group-item list-group-item-action">
                        <i class="menu-icon tf-icons bx bx-user-voice text-danger"></i>
                        {{ __('Emergency Contacts') }}
                    </a>
                @endperm


                @perm('office_setting_access')
                    <a href="{{ route('admin.setting.index') }}" class="list-group-item list-group-item-action">
                        <i class="menu-icon tf-icons bx bx-table text-primary"></i>
                        {{ __('General Setting') }}
                    </a>
                @endperm

                @perm('activity_logs access')
                    <a href="{{ route('admin.activity_logs.index') }}" class="list-group-item list-group-item-action">
                        <i class="menu-icon tf-icons bx bx-history text-primary"></i>
                        {{ __('Activity Logs') }}
                    </a>
                @endperm
            </div>
        </div>
    </div>
</div>
