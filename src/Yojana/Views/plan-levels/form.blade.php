<x-layout.app header="PlanLevel  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">PlanLevel</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($planLevel))
                    Edit
                @else
                    Create
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($planLevel))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($planLevel) ? __('yojana::yojana.create_planlevel') : __('yojana::yojana.update_planlevel') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.plan_levels.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.planlevel_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($planLevel))
                    <livewire:yojana.plan_level_form :$action :$planLevel />
                @else
                    <livewire:yojana.plan_level_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
