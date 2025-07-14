<x-layout.app header="Committee  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('yojana::yojana.committee') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($committee))
                    {{ __('yojana::yojana.create') }}
                @else
                    {{ __('yojana::yojana.edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($committee))
                        <h5 class="text-primary fw-bold"> {{ __('yojana::yojana.create_committee') }}</h5>
                    @else
                        <h5 class="text-primary fw-bold">{{ __('yojana::yojana.update_committee') }}</h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.committees.index') }}" class="btn btn-info"><i
                                class="bx bx-list-ol"></i>{{ __('yojana::yojana.committee_list') }}</a>
                    </div>
                </div>
                <div class="card-body">
                    @if (isset($committee))
                        <livewire:yojana.committee_form :$action :$committee />
                    @else
                        <livewire:yojana.committee_form :$action />
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
