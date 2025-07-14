<x-layout.app header="Customer  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Customer') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($download))
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
                @if (isset($customer))
                    <livewire:customers.customer_form :$action :$customer :isModalForm="false" />
                @else
                    <livewire:customers.customer_form :$action :isModalForm="false" />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
