<div>
    <!-- List of Departments -->
    <div class="row g-6">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ __('employees::employees.department_list') }}
                    <div>
                        <!-- Add Department Button: Clears previous data -->
                        <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal">
                            <i class="bx bx-plus"></i> {{ __('employees::employees.add_department') }}
                        </button>
                    </div>
                </div>
                <hr class="m-0">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-start gap-5">
                        <!-- Use a different variable name for the loop to avoid conflict with the component property -->
                        @foreach ($branches as $branchItem)
                            <div class="card icon-card cursor-pointer shadow-sm" wire:key="branch-{{ $branchItem->id }}"
                                style="width: 20rem; border-radius: 12px; min-height: 9rem; position: relative;">
                                <!-- This anchor tag makes the entire card clickable (except for buttons) -->
                                <a href="{{ route('admin.employee.branch.showemployee', $branchItem->id) }}"
                                    class="stretched-link"></a>
                                <div class="d-flex h-100 w-100">
                                    <!-- Image Column -->
                                    <div class="d-flex align-items-center justify-content-center"
                                        style="width: 30%; background-color: #f8f9fa;">
                                        <img src="{{ asset('assets/icons/DigitalLgProfileIcon.png') }}" alt="logo"
                                            class="img-fluid" style="width: 50px; height: 50px;">
                                    </div>
                                    <!-- Content Column -->
                                    <div class="d-flex flex-column align-items-end justify-content-center p-3"
                                        style="width: 70%;">
                                        <!-- Department Title -->
                                        <h6 class="mb-2 fw-bold text-break text-end"
                                            style="font-size: 0.95rem; line-height: 1.3; max-height: 3em; overflow: hidden;">
                                            {{ __($branchItem->title) }}
                                        </h6>
                                        <!-- Buttons -->
                                        <div class="d-flex justify-content-end gap-2 mt-1"
                                            style="position: relative; z-index: 2;">
                                            <!-- Edit Button: Pass the branch id to the editBranch method -->
                                            <button type="button" class="btn btn-primary btn-sm px-2 py-1"
                                                wire:click="editBranch({{ $branchItem->id }})">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            <!-- Delete Button -->
                                            <a href="{{ route('admin.employee.branch.delete', $branchItem->id) }}"
                                                class="btn btn-danger btn-sm px-2 py-1">
                                                <i class="bx bx-trash"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Add/Edit Department -->
    <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="planLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">
                        @if ($action === App\Enums\Action::UPDATE)
                            {{ __('employees::employees.edit_department') }}
                        @else
                            {{ __('employees::employees.add_department') }}
                        @endif
                    </h5>
                    <button type="button" class="btn-close" onclick="resetForm()" data-bs-dismiss="modal"
                        aria-label="Close">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <!-- Render the appropriate Livewire form component -->
                        @if ($action === App\Enums\Action::UPDATE && !empty($branch->id))
                            <livewire:employees.branch_form :action="App\Enums\Action::UPDATE" :branch="$branch" />
                        @else
                            <livewire:employees.branch_form :action="App\Enums\Action::CREATE" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Modal Events -->
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('open-modal', () => {
            var modalElement = document.getElementById('indexModal');
            var modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modal.show();
        });

        Livewire.on('close-modal', () => {
            var modalElement = document.getElementById('indexModal');
            var modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
            }
            resetForm();
        });
    });

    function resetForm() {
        Livewire.dispatch('reset-form');
    }
</script>
