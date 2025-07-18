<x-layout.app header="{{ __('tokentracking::tokentracking.token_log_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tokentracking::tokentracking.token_log') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('tokentracking::tokentracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">{{ __('tokentracking::tokentracking.token_log_list') }}
                        </h5>
                    </div>
                    <div>
                        @perm('token_logs create')
                            <a href="{{ route('admin.token_logs.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('tokentracking::tokentracking.add_token_log') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:token_tracking.token_log_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
