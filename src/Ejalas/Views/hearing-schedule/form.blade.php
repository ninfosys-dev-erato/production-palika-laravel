<x-layout.app header="{{ __('Hearing Schedule ' . ucfirst(strtolower($action->value)) . ' Form') }} ">
    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a
                    href="{{ route('admin.ejalas.hearing_schedules.index') }}">{{ __('ejalas::ejalas.hearing_schedule') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($hearingSchedule))
                    {{ __('ejalas::ejalas.edit') }}
                @else
                    {{ __('ejalas::ejalas.create') }}
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    @if (!isset($hearingSchedule))
                        <h5 class="text-primary fw-bold mb-0">
                            {{ !isset($hearingSchedule) ? __('ejalas::ejalas.create_hearing_schedule') : __('ejalas::ejalas.update_hearing_schedule') }}
                        </h5>
                    @endif
                    <div>
                        <a href="{{ route('admin.ejalas.hearing_schedules.index') }}" class="btn btn-info">
                            <i class="bx bx-list-ol"></i>{{ __('ejalas::ejalas.hearing_schedule_list') }}
                        </a>
                    </div>
                </div>
                @if (isset($hearingSchedule))
                    <livewire:ejalas.hearing_schedule_form :$action :$hearingSchedule :$from />
                @else
                    <livewire:ejalas.hearing_schedule_form :$action :$from />
                @endif
            </div>
        </div>
    </div>
    </div>
</x-layout.app>
