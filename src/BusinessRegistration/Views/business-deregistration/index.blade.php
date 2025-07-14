<x-layout.app header="{{ __('businessregistration::businessregistration.business_registration') }}">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="#">{{ __('businessregistration::businessregistration.business_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('businessregistration::businessregistration.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="text-primary fw-bold">


                            {{-- {{ $type . ' ' . __('businessregistration::businessregistration.business_list') }} --}}
                            {{ __('businessregistration::businessregistration.business_list') }}
                        </h5>
                        <div>
                            @perm('business-registration_access')
                                <a href="{{ route('admin.business-deregistration.create', ['type' => $type]) }}"
                                    class="btn btn-info"><i class="bx bx-plus"></i>

                                    {{ __('businessregistration::businessregistration.apply') }}</a>
                            @endperm
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <livewire:business_registration.business_de_registration_table theme="bootstrap-4" :$type />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
