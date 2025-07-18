<x-layout.app header="Decision  {{ ucfirst(strtolower($action->value)) }} Form">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Decision') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                {{ __('Meeting Decision') }} @if (isset($decision))
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
                @if (isset($decision))
                    <livewire:meetings.decision_form :$action :$decision :meetingId="request('meeting')"/>
                @else
                    <livewire:meetings.decision_form :$action :meetingId="request('meeting')" />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
