<div class="col-md-6" style="position: relative; display: inline-block; z-index: 1000;">
    <div class="demo-inline-spacing">
        <div class="btn-group" wire:ignore>
            <button class="btn btn-sm btn-success dropdown-toggle" type="button" id="actionDropdown{{ $row->id }}"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-dots-vertical-rounded"></i>
                <style>
                    #actionDropdown{{ $row->id }}::after {
                        display: none !important;
                    }
                </style>
            </button>

            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionDropdown{{ $row->id }}"
                style="min-width: 10rem;">
                <li>
                    <a class="dropdown-item" href="#" wire:click.prevent="view({{ $row->id }})"
                        style="display: flex; align-items: center;">
                        <i class="bx bx-show me-2"></i> View
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" wire:click.prevent="edit({{ $row->id }})"
                        style="display: flex; align-items: center;">
                        <i class="bx bx-edit me-2"></i> Edit
                    </a>
                </li>
                <li>
                    <a class="dropdown-item text-danger" href="#" wire:click.prevent="delete({{ $row->id }})"
                        onclick="confirm('Are you sure you want to delete this record?') || event.stopImmediatePropagation()"
                        style="display: flex; align-items: center;">
                        <i class="bx bx-trash me-2"></i> Delete
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="#" wire:click.prevent="moveFurther({{ $row->id }})"
                        style="display: flex; align-items: center;">
                        <i class="bx bx-right-arrow-alt me-2"></i> Move Forward
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
