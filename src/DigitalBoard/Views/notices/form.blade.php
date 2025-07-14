<x-layout.app header="{{__('Notice '. ucfirst(strtolower($action->value)).' Form')}}">

    {{-- Bread Crumbs --}}
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{__('digitalboard::digitalboard.notice')}}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($notice))
                    {{__('digitalboard::digitalboard.edit')}}
                @else
                    {{__('digitalboard::digitalboard.create')}}
                @endif
            </li>
        </ol>
    </nav>

    {{-- Form Body --}}
    <div class="card">

        {{-- Form title --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="text-primary fw-bold mb-0">
                {{ __('digitalboard::digitalboard.notice') }} {{ $action->value === 'create' ? __('digitalboard::digitalboard.create') : __('digitalboard::digitalboard.edit') }}</h5>
            <a href="{{ route('admin.digital_board.notices.index') }}" class="btn btn-info"><i
                    class="bx bx-list-ul"></i>{{ __('digitalboard::digitalboard.notices') }}</a>
        </div>

        {{-- Form --}}
        <div class="card-body">
            @if (isset($notice))
                <livewire:digital_board.notice_form :$action :$notice />
            @else
                <livewire:digital_board.notice_form :$action />
            @endif
        </div>
    </div>
</x-layout.app>
