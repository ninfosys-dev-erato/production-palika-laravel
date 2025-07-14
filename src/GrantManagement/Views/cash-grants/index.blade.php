<x-layout.app header="{{ __('grantmanagement::grantmanagement.cash_grant_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grantmanagement::grantmanagement.cash_grant') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grantmanagement::grantmanagement.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('grantmanagement::grantmanagement.cash_grant_list') }}</h5>
                    </div>
                    <div>
                        @perm('cash_grants create')
                            <a href="{{ route('admin.cash_grants.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i> {{ __('grantmanagement::grantmanagement.add_cash_grant') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:grant_management.cash_grant_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
