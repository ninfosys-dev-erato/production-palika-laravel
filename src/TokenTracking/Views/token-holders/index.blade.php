<x-layout.app header="{{ __('tokentracking::tokentracking.token_holder_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tokentracking::tokentracking.token_holder') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('tokentracking::tokentracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('tokentracking::tokentracking.token_holder_list') }}
                        </h5>
                    </div>
                    <div>
                        @perm('token_holders create')
                            <a href="{{ route('admin.token_holders.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('tokentracking::tokentracking.add_token_holder') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:token_tracking.token_holder_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
