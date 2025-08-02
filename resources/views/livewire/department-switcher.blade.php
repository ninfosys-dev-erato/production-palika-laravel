<?php

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

$departments = Cache::remember('user_departments_' . auth()->id(), Carbon::now()->addDay(), function () {
    return auth()->user()->departments()->get();
});

$selectedDepartmentId = session()->get('department');
$selectedDepartmentTitle = 'N/A';

// If no department is selected in session, try to get the first available department
if (!$selectedDepartmentId && $departments->count() > 0) {
    $selectedDepartmentId = $departments->first()->id;
    session(['department' => $selectedDepartmentId]);
}

// Get the selected department title
if ($selectedDepartmentId) {
    $selectedDepartment = $departments->firstWhere('id', $selectedDepartmentId);
    $selectedDepartmentTitle = $selectedDepartment ? $selectedDepartment->title : 'N/A';
}

?>
<ul class="navbar-nav me-auto mb-2 mb-lg-0">
    @if ($departments->count() > 0)
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbarDropdown" role="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                {{ __('Department') . ' : ' . $selectedDepartmentTitle }}
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                @foreach ($departments as $department)
                    <li>
                        <a class="dropdown-item" wire:click="changeDepartment({{ $department->id }})" href="#">
                            {{ __('Department') . ' ' . $department->title }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @else
        <li class="nav-item">
            <a class="nav-link disabled" href="javascript:void(0)" tabindex="-1">{{ __('No Department Selected') }}</a>
        </li>
    @endif
</ul>


@script
    <script>
        $wire.on('department-change', () => {
            window.location.reload();
        });
    </script>
@endscript
