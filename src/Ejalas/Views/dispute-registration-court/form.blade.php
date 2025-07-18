<x-layout.app header="{{ __('Dispute Registration Court ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.dispute_registration_courts.index') }}">{{ __('ejalas::ejalas.dispute_registration_court') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($disputeRegistrationCourt))
                    {{ __('ejalas::ejalas.edit') }}
                @else
                    {{ __('ejalas::ejalas.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($disputeRegistrationCourt))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($disputeRegistrationCourt) ? __('ejalas::ejalas.create_dispute_registration_court') : __('ejalas::ejalas.update_dispute_registration_court') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.dispute_registration_courts.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.dispute_registration_court_list') }}
                        </a>
                    </div>
                </div>

            </div>
            @if (isset($disputeRegistrationCourt))
                <livewire:ejalas.dispute_registration_court_form :$action :$disputeRegistrationCourt />
            @else
                <livewire:ejalas.dispute_registration_court_form :$action />
            @endif
        </div>
    </div>
</x-layout.app>
