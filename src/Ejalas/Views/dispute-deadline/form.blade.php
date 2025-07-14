<x-layout.app header="{{ __('Dispute Deadline ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.dispute_deadlines.index') }}">{{ __('ejalas::ejalas.dispute_deadline') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($disputeDeadline))
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
                    @if (!isset($disputeDeadline))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($disputeDeadline) ? __('ejalas::ejalas.create_dispute_deadline') : __('ejalas::ejalas.update_dispute_deadline') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.dispute_deadlines.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.dispute_deadline_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($disputeDeadline))
                    <livewire:ejalas.dispute_deadline_form :$action :$disputeDeadline />
                @else
                    <livewire:ejalas.dispute_deadline_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
