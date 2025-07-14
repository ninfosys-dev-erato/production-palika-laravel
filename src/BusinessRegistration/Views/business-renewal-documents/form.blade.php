<x-layout.app header="{{__('Business Renewal Document '.ucfirst(strtolower($action->value)) .' Form')}} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                        href="{{route('admin.business_renewal_documents.index')}}">{{__('businessregistration::businessregistration.business_renewal_document')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(isset($businessRenewalDocument))
                    {{__('businessregistration::businessregistration.edit')}}
                @else
                    {{__('businessregistration::businessregistration.create')}}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($businessRenewalDocument))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($businessRenewalDocument) ? __('businessregistration::businessregistration.create_business_renewal_document') : __('businessregistration::businessregistration.update_business_renewal_document') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route("admin.business_renewal_documents.index")}}"
                           class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('businessregistration::businessregistration.business_renewal_document_list') }}
                        </a>
                    </div>
                </div>
                @if(isset($businessRenewalDocument))
                    <livewire:business_registration.business_renewal_document_form :$action
                                                                                        :$businessRenewalDocument/>
                @else
                    <livewire:business_registration.business_renewal_document_form :$action/>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
