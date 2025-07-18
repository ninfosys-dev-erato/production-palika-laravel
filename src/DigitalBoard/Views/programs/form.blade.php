<x-layout.app header="{{__('Program '. ucfirst(strtolower($action->value)) .' Form')}}">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('digitalboard::digitalboard.program') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($program))
                    {{ __('digitalboard::digitalboard.edit') }}
                @else
                    {{ __('digitalboard::digitalboard.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ __('digitalboard::digitalboard.program') }} {{ $action->value === 'create' ? __('digitalboard::digitalboard.create') : __('digitalboard::digitalboard.edit') }}</h5>
            <a href="{{ route('admin.digital_board.programs.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('digitalboard::digitalboard.programs') }}</a>
        </div>

        <div class="card-body">
            @if (isset($program))
                <livewire:digital_board.program_form :$action :$program />
            @else
                <livewire:digital_board.program_form :$action />
            @endif
        </div>
    </div>
</x-layout.app>
