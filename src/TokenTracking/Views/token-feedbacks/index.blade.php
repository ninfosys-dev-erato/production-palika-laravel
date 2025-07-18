<x-layout.app header="{{ __('tokentracking::tokentracking.token_feedback_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('tokentracking::tokentracking.token_feedback') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('tokentracking::tokentracking.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('tokentracking::tokentracking.token_feedback_list') }}</h5>
                    </div>
                    <div>
                        @perm('register_tokens create')
                            <a href="{{ route('admin.token_feedbacks.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('tokentracking::tokentracking.add_token_feedback') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:token_tracking.token_feedback_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
