<x-layout.app header="Plan Area  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('yojana::yojana.plan_area')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($planArea))
                    {{__('yojana::yojana.edit')}}
                @else
                    {{__('yojana::yojana.create')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($planArea))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($planArea) ? __('yojana::yojana.create_plan_area') : __('yojana::yojana.update_plan_area') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.plan_areas.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.plan_area_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($planArea))
                    <livewire:yojana.plan_area_form :$action :$planArea />
                @else
                    <livewire:yojana.plan_area_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
