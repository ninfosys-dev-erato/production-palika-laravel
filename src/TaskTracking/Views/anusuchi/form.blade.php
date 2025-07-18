<x-layout.app header="{{ __('Anusuchi ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.anusuchis.index') }}">{{ __('tasktracking::tasktracking.anusuchi') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($anusuchi))
                    {{ __('tasktracking::tasktracking.edit') }}
                @else
                    {{ __('tasktracking::tasktracking.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($anusuchi))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($anusuchi) ? __('tasktracking::tasktracking.create_anusuchi') : __('tasktracking::tasktracking.update_anusuchi') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.anusuchis.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('tasktracking::tasktracking.anusuchi_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($anusuchi))
                    <livewire:task_tracking.anusuchi_form :$action :$anusuchi />
                @else
                    <livewire:task_tracking.anusuchi_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
