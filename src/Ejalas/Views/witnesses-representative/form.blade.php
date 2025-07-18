<x-layout.app header="{{ __('Witnesses Representative ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.witnesses_representatives.index') }}">{{ __('ejalas::ejalas.witnesses_representative') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($witnessesRepresentative))
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
                    @if (!isset($witnessesRepresentative))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($witnessesRepresentative) ? __('ejalas::ejalas.create_witnesses_representative') : __('ejalas::ejalas.update_witnesses_representative') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.witnesses_representatives.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.witnesses_representative_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($witnessesRepresentative))
                    <livewire:ejalas.witnesses_representative_form :$action :$witnessesRepresentative />
                @else
                    <livewire:ejalas.witnesses_representative_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
