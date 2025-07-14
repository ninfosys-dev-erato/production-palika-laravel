<x-layout.app header="{{ __('ebps::ebps.four_boundary_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.four_boundary') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('ebps::ebps.four_boundary_list') }}</h5>
                    </div>
                    <div>
                        @perm('four_boundaries create')
                            <a href="{{ route('admin.four_boundaries.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('ebps::ebps.add_four_boundary') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:four_boundaries.four_boundary_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
