<x-layout.business-app header="Map Apply List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.map_apply') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('ebps::ebps.map_applications') }}
                        </h5>
                    </div>

                    @if (!config('settings.hide_button'))
                        <div>
                            <a href="{{ route('organization.ebps.map_apply.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('ebps::ebps.add_map_apply') }}</a>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <livewire:business_portal.ebps.organization_map_apply_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>

</x-layout.business-app>
