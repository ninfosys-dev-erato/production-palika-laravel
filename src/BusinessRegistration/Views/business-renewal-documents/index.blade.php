<x-layout.app header="{{ __('businessregistration::businessregistration.business_renewal_document_list') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('businessregistration::businessregistration.business_renewal_document') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('businessregistration::businessregistration.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header  d-flex justify-content-between">
                    <div class="d-flex justify-content-between card-header">
                        <h5 class="text-primary fw-bold mb-0">
                            {{ __('businessregistration::businessregistration.business_renewal_document_list') }}</h5>
                    </div>
                    <div>
                        @perm('business_renewal_documents create')
                            <a href="{{ route('admin.business_renewal_documents.create') }}" class="btn btn-info"><i
                                    class="bx bx-plus"></i>
                                {{ __('businessregistration::businessregistration.add_business_renewal_document') }}</a>
                        @endperm
                    </div>
                </div>
                <div class="card-body">
                    <livewire:business_registration.business_renewal_document_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
