<x-layout.app header="Document  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">Document</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($document))
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
                    @if (!isset($document))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($document) ? __('ebps::ebps.create_document') : __('ebps::ebps.update_document') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ebps.documents.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ebps::ebps.document_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($document))
                    <livewire:ebps.document_form :$action :$document />
                @else
                    <livewire:ebps.document_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
