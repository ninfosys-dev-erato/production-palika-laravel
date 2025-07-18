<x-layout.app header="Committee  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Committee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($committee))
                    {{ __('Create') }}
                @else
                    {{ __('Edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($committee))
                        <h5 class="text-primary fw-bold"> {{ __('Create Committee') }}</h5>
                    @else
                        <h5 class="text-primary fw-bold">{{ __('Update Committee') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.committees.index') }}" class="btn btn-info"><i
                                class="bx bx-list-ol"></i>{{ __('Committee List') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($committee))
                        <livewire:committees.committee_form :$action :$committee />
                    @else
                        <livewire:committees.committee_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
