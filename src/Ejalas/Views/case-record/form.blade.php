<x-layout.app header="{{ __('Case Record ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.case_records.index') }}">{{ __('ejalas::ejalas.case_record') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($caseRecord))
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
                    @if (!isset($caseRecord))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($caseRecord) ? __('ejalas::ejalas.create_case_record') : __('ejalas::ejalas.update_case_record') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.case_records.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.case_record_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($caseRecord))
                    <livewire:ejalas.case_record_form :$action :$caseRecord />
                @else
                    <livewire:ejalas.case_record_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
