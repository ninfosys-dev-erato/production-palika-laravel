<x-layout.app header="{{ __('Evaluation ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.evaluations.index') }}">{{ __('yojana::yojana.evaluation') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($evaluation))
                    {{ __('yojana::yojana.edit') }}
                @else
                    {{ __('yojana::yojana.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($evaluation))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($evaluation) ? __('yojana::yojana.create_evaluation') : __('yojana::yojana.update_evaluation') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.evaluations.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.evaluation_list') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($evaluation))
            <livewire:yojana.evaluation_form :$action :$evaluation :$plan />
        @else
            <livewire:yojana.evaluation_form :$action />
        @endif

    </div>
    </div>
</x-layout.app>
