<x-layout.customer-app header="Customer  {{ ucfirst(strtolower($action->value)) }} Form">
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                @if (isset($customer))
                    <livewire:customer_portal.customer_kyc.customer_form :$action :$customer />
                @else
                    <livewire:customer_portal.customerKyc.customer_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.customer-app>
