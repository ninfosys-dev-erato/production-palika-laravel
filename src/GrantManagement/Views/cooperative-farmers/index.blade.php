<x-layout.app header="{{ __('grantmanagement::grantmanagement.cooperative_farmer_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('grantmanagement::grantmanagement.cooperative_farmer') }}</a>
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
                            {{ __('grantmanagement::grantmanagement.cooperative_farmer_list') }}</h5>
                    </div>
                    <div>
                        @perm('cooperative_farmers create')
                            <a href="{{ route('admin.cooperative_farmers.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('grantmanagement::grantmanagement.add_cooperative_farmer') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:grant_management.cooperative_farmer_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
