<x-layout.business-app header="{{ __('Dashboard') }}">
    <div class="row">
        <!-- Welcome Card -->
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">{{ __('Welcome') }}
                                {{-- {{ auth('organization')->user()->name }} --}}
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

    </div>
</x-layout.business-app>
