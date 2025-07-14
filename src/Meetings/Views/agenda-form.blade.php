<x-layout.app header="Agenda  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Agenda') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Meeting Agendas') }} @if (isset($agenda))
                    {{ __('Create') }}
                @else
                    {{ __('Edit') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card-header d-flex justify-content-between">
                {{ __('Meeting Agenda List') }}
              
            </div>
            <div class="card">
                @if (isset($agenda))
                    <livewire:meetings.agenda_form :$action :$agenda :meetingId="request('meeting')"/>
                @else
                    <livewire:meetings.agenda_form :$action :meetingId="request('meeting')"/>
                @endif
            </div>
        </div>
    </div>

</x-layout.app>