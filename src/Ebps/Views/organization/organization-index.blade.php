<x-layout.app header="Organization List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('ebps::ebps.organization') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('ebps::ebps.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('ebps::ebps.organization') }}
                    </h5>
                    <a href="{{ route('admin.ebps.organizations.create') }}" class="btn btn-info"><i
                            class="bx bx-plus"></i>
                        {{ __('ebps::ebps.add_organization') }}</a>
                </div>
                <div class="card-body">
                    <livewire:ebps.organization_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
