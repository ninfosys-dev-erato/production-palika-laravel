<x-layout.app header="{{ __('beruju::beruju.beruju_registration_form') }}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.beruju.index') }}">{{ __('beruju::beruju.beruju_registration') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($berujuEntry))
                    {{ __('beruju::beruju.create') }}
                @else
                    {{ __('beruju::beruju.edit') }}
                @endif
            </li>
        </ol>
    </nav>

    <div class="card mb-3 rounded-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ __('beruju::beruju.entry_form') }}
            </h5>

            <a href="{{ route('admin.beruju.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('beruju::beruju.beruju_registration_lists') }}</a>
        </div>
    </div>
    @if (isset($berujuEntry))
        <livewire:beruju.beruju_entry_form :$action :$berujuEntry />
    @else
        <livewire:beruju.beruju_entry_form :$action />
    @endif


</x-layout.app>
