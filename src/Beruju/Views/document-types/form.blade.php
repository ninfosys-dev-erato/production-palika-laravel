<x-layout.app header="{{ $action === \App\Enums\Action::CREATE ? __('beruju::beruju.create_document_type') : __('beruju::beruju.edit_document_type') }}">
    <div class="row">
        <div class="col-12">
            <div class="card rounded-0">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.beruju.document-types.index') }}">{{ __('beruju::beruju.document_types') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                                {{ $action === \App\Enums\Action::CREATE ? __('beruju::beruju.create') : __('beruju::beruju.edit') }}
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <livewire:beruju.document_type_form :documentType="$documentType ?? null" :action="$action" />
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.beruju.document-types.index') }}" class="btn btn-info rounded-0">
                            <i class="fas fa-arrow-left"></i> {{ __('beruju::beruju.back_to_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
