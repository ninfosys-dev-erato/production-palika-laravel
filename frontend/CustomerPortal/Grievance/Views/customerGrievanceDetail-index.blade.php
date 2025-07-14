<x-layout.customer-app header="{{ __('grievance::grievance.grievance_list') }}">>

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.setting') }}</a>
            </li>
            <li class="breadcrumb-item"><a href="#">{{ __('grievance::grievance.grievance_detail') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('grievance::grievance.list') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">

                <div class="d-flex justify-content-between card-header">
                    <h5 class="text-primary fw-bold mb-0">
                        {{ __('grievance::grievance.grievance_detail_list') }}</h5>
                </div>

                <div>
                    <a href="{{ route('customer.grievance.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                        {{ __('grievance::grievance.add_grievance') }}</a>
                </div>
            </div>
            <div class="card-body">
                <livewire:customer_portal.grievance.customer_gunaso_table theme="bootstrap-4" />
            </div>
        </div>
    </div>
</x-layout.customer-app>
