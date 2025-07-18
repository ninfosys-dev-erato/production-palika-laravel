<x-layout.app header="{{ __('Meeting List') }}">


    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">{{ __('Meeting') }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('List') }}</li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="text-primary fw-bold"> {{ __('Meeting List') }}</h5>
                    @perm('meeting_create')
                        <div>
                            <a href="{{ route('admin.meetings.create') }}" class="btn btn-info"><i class="bx bx-plus"></i>
                                {{ __('Add Meeting') }}</a>
                        </div>
                    @endperm

                </div>
                <div class="card-body">
                    <livewire:meetings.meeting_table theme="bootstrap-4" />
                </div>
            </div>
        </div>
    </div>
</x-layout.app>
