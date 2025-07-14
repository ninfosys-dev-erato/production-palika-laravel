<x-layout.app header="{{ __('Activity ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="{{ route('admin.activities.index') }}">{{ __('yojana::yojana.activity') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($activity))
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
                    @if (!isset($activity))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($activity) ? __('yojana::yojana.create_activity') : __('yojana::yojana.update_activity') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.activities.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('yojana::yojana.activity_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($activity))
                    <livewire:yojana.activity_form :$action :$activity />
                @else
                    <livewire:yojana.activity_form :$action />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
