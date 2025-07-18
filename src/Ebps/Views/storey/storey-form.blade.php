<x-layout.app header="Storey  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('ebps::ebps.storey')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($storey))
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
                    @if (!isset($storey))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($storey) ? __('ebps::ebps.create_storey') : __('ebps::ebps.update_storey') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.storeys.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.storey_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($storey))
                    <livewire:ebps.storey_form :$action :$storey />
                @else
                    <livewire:ebps.storey_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
