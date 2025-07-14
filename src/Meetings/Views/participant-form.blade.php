<x-layout.app header="Participant  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Participant') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Participant') }} @if (isset($participant))
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
                    {{ __('Participants Create') }}       
                </div>
                @if (isset($participant))
                    <livewire:meetings.participant_form :$action :$participant :meetingId="request('meeting')"/>
                @else
                    <livewire:meetings.participant_form :$action :meetingId="request('meeting')"/>
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>