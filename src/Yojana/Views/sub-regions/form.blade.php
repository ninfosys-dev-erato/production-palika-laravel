<x-layout.app header="{{ __('Sub Region ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.sub_regions.index') }}">{{ __('yojana::yojana.sub_region') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($subRegion))
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
                    @if (!isset($subRegion))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($subRegion) ? __('yojana::yojana.create_sub_region') : __('yojana::yojana.update_sub_region') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.sub_regions.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.sub_region_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($subRegion))
                    <livewire:yojana.sub_region_form :$action :$subRegion />
                @else
                    <livewire:yojana.sub_region_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
