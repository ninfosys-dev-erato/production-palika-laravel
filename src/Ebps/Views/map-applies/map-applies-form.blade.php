<x-layout.app header="Map Apply  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.mapapply') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($mapApply))
                    {{ __('ebps::ebps.create') }}
                @else
                    {{ __('ebps::ebps.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (isset($mapApply))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ isset($mapApply) ? __('ebps::ebps.update_mapapply') : __('ebps::ebps.create_mapapply') }}
                        </h5>
                    @endif
                    
                    <div>
                        <a href="{{ route('admin.ebps.map_applies.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.mapapply_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($mapApply))
                    <livewire:ebps.map_apply_form :$action :$mapApply />
                @else
                    <livewire:ebps.map_apply_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
