<x-layout.app header="MapStep  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('ebps::ebps.map_step')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($mapStep))
                    {{__('ebps::ebps.create')}}
                @else
                    {{__('ebps::ebps.edit')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($mapStep))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($mapStep) ? __('ebps::ebps.create_map_step') : __('ebps::ebps.update_map_step') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.map_steps.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.map_step_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($mapStep))
                    <livewire:ebps.map_step_form :$action :$mapStep />
                @else
                    <livewire:ebps.map_step_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
