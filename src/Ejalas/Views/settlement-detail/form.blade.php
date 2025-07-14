<x-layout.app header="{{ __('Settlement Detail ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.settlement_details.index') }}">{{ __('ejalas::ejalas.settlement_detail') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($settlementDetail))
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
                    @if (!isset($settlementDetail))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($settlementDetail) ? __('ejalas::ejalas.create_settlement_detail') : __('ejalas::ejalas.update_settlement_detail') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.settlement_details.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.settlement_detail_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($settlementDetail))
                    <livewire:ejalas.settlement_detail_form :$action :$settlementDetail />
                @else
                    <livewire:ejalas.settlement_detail_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
