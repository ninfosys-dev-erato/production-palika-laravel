<x-layout.app header="{{ __('yojana::yojana.committee_type_list') }}">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.committee_type') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold">{{ __('yojana::yojana.committee_type_list') }}</h5>

                    @perm('committee_type_create')
                        <div>
                            <a href="{{ route('admin.committee-types.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('yojana::yojana.add_committee_type') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:committees.committee_type_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
