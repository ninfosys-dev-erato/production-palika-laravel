<x-layout.app header="MapImportantDocument  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">MapImportantDocument</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($mapImportantDocument))
                    Create
                @else
                    Edit
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($mapImportantDocument))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($mapImportantDocument) ? __('ebps::ebps.create_mapimportantdocument') : __('ebps::ebps.update_mapimportantdocument') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.map_important_documents.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.mapimportantdocument_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($mapImportantDocument))
                    <livewire:ebps.map_important_document_form :$action :$mapImportantDocument />
                @else
                    <livewire:ebps.map_important_document_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
