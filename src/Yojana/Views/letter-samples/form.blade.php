<x-layout.app header="{{ __('Letter Sample ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.plan.index') }}">{{ __('yojana::yojana.plan_management') }}</a>
            <li class="breadcrumb-item"><a href="{{ route('admin.letter_samples.index') }}">{{ __('yojana::yojana.letter_sample') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($letterSample))
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
                    @if (!isset($letterSample))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($letterSample) ? __('yojana::yojana.create_letter_sample') : __('yojana::yojana.update_letter_sample') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.letter_samples.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.letter_sample_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($letterSample))
                    <livewire:yojana.letter_sample_form :$action :$letterSample />
                @else
                    <livewire:yojana.letter_sample_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
