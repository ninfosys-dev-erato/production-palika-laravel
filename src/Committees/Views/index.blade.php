<x-layout.app header="Committee List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Committee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="text-primary fw-bold">{{ __('Committee List') }}</h5>
                        @perm('committee_create')
                            <div>
                                <a href="{{ route('admin.committees.create') }}" class="btn btn-info"><i
                                        class="bx bx-plus"></i> {{ __('Add Committee') }}</a>
                            </div>
                        @endperm

                    </div>
                    <div class="card-body">
                        <livewire:committees.committee_table theme="bootstrap-4" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
