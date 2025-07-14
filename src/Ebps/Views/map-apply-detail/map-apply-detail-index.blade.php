<x-layout.app header="MapApplyDetail List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.mapapplydetail') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    @perm('map_apply_details create')
                        <a href="{{ route('admin.map_apply_details.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> {{ __('ebps::ebps.add_mapapplydetail') }}</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:ebps.map_apply_detail_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
