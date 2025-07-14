<x-layout.app header="MapPassGroup List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.map_pass_group') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('ebps::ebps.map_pass_group') }}
                    </h5>
                    @perm('ebps_settings create')
                        <a href="{{ route('admin.ebps.map_pass_groups.create') }}" class="btn btn-info"><i
                                class="bx bx-plus"></i> {{ __('ebps::ebps.add_map_pass_group') }}</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:ebps.map_pass_group_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
