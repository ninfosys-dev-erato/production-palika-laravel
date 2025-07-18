<x-layout.app header="ActivityLog  {{ ucfirst(strtolower($action->value)) }} Form">

    <nav aria-label="breadcrumb" class="d-flex justify-content-end">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
            <li class="breadcrumb-item"><a href="#">ActivityLog</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                @if (isset($activityLog))
                    Create
                @else
                    Edit
                @endif
            </li>
        </ol>
    </nav>
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                @if (isset($activityLog))
                    <livewire:activity_logs.activity_log_form :$action :$activityLog />
                @else
                    <livewire:activity_logs.activity_log_form :$action />
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
