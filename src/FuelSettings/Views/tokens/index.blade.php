<x-layout.app header="Token List">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Token</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">List</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('Token Request') }}
                    </h5>
                    @perm('fms_tokens create')
                        <a href="{{ route('admin.tokens.create') }}" class="btn btn-info"><i class="bx bx-plus"></i> Add
                            Token</a>
                    @endperm
                </div>
                <div class="card-body">
                    <livewire:fuel_settings.token_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
