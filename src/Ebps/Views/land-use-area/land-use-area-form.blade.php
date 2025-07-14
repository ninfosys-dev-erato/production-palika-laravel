<x-layout.app header="LandUseArea  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.land_use_area') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($landUseArea))
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
                    @if (!isset($landUseArea))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($landUseArea) ? __('ebps::ebps.create_land_use_area') : __('ebps::ebps.update_land_use_area') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.land_use_areas.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.land_use_area_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($landUseArea))
                    <livewire:ebps.land_use_area_form :$action :$landUseArea />
                @else
                    <livewire:ebps.land_use_area_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
