<x-layout.customer-app header="Gunaso  {{ ucfirst(strtolower($action->value)) }} Form">
    <div class="container-xxl flex-grow-1 container-p-y">

        <nav aria-label="breadcrumb" class="d-flex justify-content-end">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                <li class="breadcrumb-item"><a href="#">{{ __('Grievance') }}</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    @if (isset($customerGunaso))
                        {{ __('Create') }}
                    @else
                        {{ __('Edit') }}
                    @endif
                </li>
            </ol>
        </nav>
        <div class="row g-6">
            <div class="col-md-12">
                <div class="card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            @if (!isset($customerGunaso))
                                {{ __('Create') }}
                            @else
                                {{ __('Edit') }}
                            @endif {{ __('Complaint') }}
                            <div>
                                <a href="{{ route('customer.grievance.index') }}" class="btn btn-info"><i
                                        class="bx bx-list-ol"></i>{{ __('Grievance List') }}</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (isset($customerGunaso))
                                <livewire:customer.gunaso.gunaso-fomr :$action :$customerGunaso />
                            @else
                                <livewire:customer.gunaso.gunaso-fomr :$action />
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layout.customer-app>
