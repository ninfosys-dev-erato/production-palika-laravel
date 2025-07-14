<x-layout.app header="{{ __('Legal Document ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.legal_documents.index') }}">{{ __('ejalas::ejalas.legal_document') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($legalDocument))
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
                    @if (!isset($legalDocument))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($legalDocument) ? __('ejalas::ejalas.create_legal_document') : __('ejalas::ejalas.update_legal_document') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.legal_documents.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.legal_document_list') }}
                        </a>
                    </div>
                </div>
            </div>
            @if (isset($legalDocument))
                <livewire:ejalas.legal_document_form :$action :$legalDocument />
            @else
                <livewire:ejalas.legal_document_form :$action />
            @endif
        </div>
    </div>
    </div>
</x-layout.app>
