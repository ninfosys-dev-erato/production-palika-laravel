<x-layout.app header="{{ __('Reconciliation Center ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.reconciliation_centers.index') }}">{{ __('ejalas::ejalas.reconciliation_center') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($reconciliationCenter))
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
                    @if (!isset($reconciliationCenter))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($reconciliationCenter) ? __('ejalas::ejalas.create_reconciliation_center') : __('ejalas::ejalas.update_reconciliation_center') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.reconciliation_centers.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.reconciliation_center_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($reconciliationCenter))
                    <livewire:ejalas.reconciliation_center_form :$action :$reconciliationCenter />
                @else
                    <livewire:ejalas.reconciliation_center_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>