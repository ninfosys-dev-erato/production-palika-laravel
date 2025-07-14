<x-layout.app header="{{ __('Project Activity Group ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.project_activity_groups.index') }}">{{ __('yojana::yojana.project_activity_group') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($projectActivityGroup))
                    {{ __('yojana::yojana.edit') }}
                @else
                    {{ __('yojana::yojana.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($projectActivityGroup))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($projectActivityGroup) ? __('yojana::yojana.create_project_activity_group') : __('yojana::yojana.update_project_activity_group') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.project_activity_groups.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.project_activity_group_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($projectActivityGroup))
                    <livewire:yojana.project_activity_group_form :$action :$projectActivityGroup />
                @else
                    <livewire:yojana.project_activity_group_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
