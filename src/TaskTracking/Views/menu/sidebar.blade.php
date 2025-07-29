<li class="menu-header small text-uppercase">
    <span class="menu-header-text">{{ __('tasktracking::tasktracking.task_tracking') }}</span>
</li>
@perm('tsk_management access')
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.tasks.index') ? 'active' : '' }}">
        <a href="{{ route('admin.tasks.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-group"></i>
            <div data-i18n="Tasks">{{ __('tasktracking::tasktracking.tasks') }}</div>
        </a>
    </li>
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.anusuchi.report') ? 'active' : '' }}">
        <a href="{{ route('admin.anusuchis.report') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-building"></i>
            <div data-i18n="Task Type">{{ __('tasktracking::tasktracking.make_report') }}</div>
        </a>
    </li>
@endperm
@perm('tsk_management access')
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.task.projects.index') ? 'active' : '' }}">
        <a href="{{ route('admin.task.projects.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-bell-plus"></i>
            <div data-i18n="Projects">{{ __('tasktracking::tasktracking.projects') }}</div>
        </a>
    </li>
    <li class="menu-item {{ \Illuminate\Support\Facades\Route::is('admin.task-types.index') ? 'active' : '' }}">
        <a href="{{ route('admin.task-types.index') }}" class="menu-link">
            <i class="menu-icon tf-icons bx bx-building"></i>
            <div data-i18n="Task Type">{{ __('tasktracking::tasktracking.task_type') }}</div>
        </a>
    </li>
    <li class="menu-item" style="">
        <a href="#" class="menu-link menu-toggle">
            <i class="menu-icon tf-icons bx bx-checkbox-square"></i>
            <div data-i18n="{{ __('tasktracking::tasktracking.public_settings') }}">
                {{ __('tasktracking::tasktracking.report_settings') }} </div>
        </a>
        <ul class="menu-sub">
            <li class="menu-item ">
                <a href="{{ route('admin.anusuchis.index') }}" class="menu-link">
                    <div data-i18n="{{ __('tasktracking::tasktracking.anusuchis') }}">
                        {{ __('tasktracking::tasktracking.anusuchis') }}</div>
                </a>
            </li>
        </ul>
    </li>
@endperm
