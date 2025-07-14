<x-layout.app header="{{ __('tasktracking::tasktracking.anusuchi_template_') }} ">

    <body>
        <div class="card p-5 ">
            <div class="row">
                @if ($action === App\Enums\Action::CREATE)
                    <livewire:task_tracking.report_anusuchi :$action />
                @else
                    <livewire:task_tracking.report_anusuchi :$action :$employeeMarkingId />
                @endif
            </div>
        </div>
    </body>
</x-layout.app>
