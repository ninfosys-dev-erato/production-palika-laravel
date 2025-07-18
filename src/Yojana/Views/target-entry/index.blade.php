<x-layout.app header="{{ __('yojana::yojana.target_entry_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.target_entry') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('yojana::yojana.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('yojana::yojana.target_entry_list') }}</h5>
                    </div>
                    <div>
                        @perm('target_entries create')
                            <a href="{{ route('admin.target_entries.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('yojana::yojana.add_target_entry') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:yojana.target_entry_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
