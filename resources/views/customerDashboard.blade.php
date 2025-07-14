<x-layout.customer-app header="{{ __('Dashboard') }}">
    @php
        $customer = Src\Customers\Models\Customer::where('id', Auth::guard('customer')->id())->with('kyc')->first();
    @endphp
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ __('Welcome') }} {{ auth('customer')->user()->name }}
                            </h5>
                            <p class="mb-4">
                                {{ __('Welcome to digital e-palika system.') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/2807920.jpg') }}" height="160" alt="Hello" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (empty($customer->kyc))
            <div class="col-lg-5 mb-4">
                <div class="card">
                    <div class="card-body">
                        <p class="text-warning">
                            {{ __('Please complete your KYC to use the services of the e-palika system.') }}
                        </p>
                        <a href="{{ route('customer.kyc.index') }}" class="btn btn-primary">{{ __('Complete KYC') }}</a>

                    </div>
                </div>
            </div>
        @elseif($customer->kyc && $customer->kyc->status->value == 'pending')
            <div class="col-lg-5 mb-4">
                <div class="card">
                    <div class="card-body">
                        <p class="text-warning">
                            {{ __('Your KYC is currently pending. Please wait for approval.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-layout.customer-app>
