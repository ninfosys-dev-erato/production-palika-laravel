<x-layout.app header="{{__('Citizen Charter '. ucfirst(strtolower($action->value)) .' Form')}}">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('digitalboard::digitalboard.citizen_charter')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($citizenCharter))
                    {{__('digitalboard::digitalboard.edit')}}
                @else
                    {{__('digitalboard::digitalboard.create')}}
                @endif
            </li>
        </ol>
    </nav>

    <div class="card">

        {{-- Form title --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ __('digitalboard::digitalboard.citizen_charter') }} {{ $action->value === 'create' ? __('digitalboard::digitalboard.create') : __('digitalboard::digitalboard.edit') }}</h5>
            <a href="{{ route('admin.digital_board.citizen_charters.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('digitalboard::digitalboard.citizen_charters') }}</a>
        </div>

        {{-- Form --}}
        <div class="card-body">
            @if (isset($citizenCharter))
                <livewire:digital_board.citizen_charter_form :$action :$citizenCharter />
            @else
                <livewire:digital_board.citizen_charter_form :$action />
            @endif
        </div>
    </div>
</x-layout.app>
