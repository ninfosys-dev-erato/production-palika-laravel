<div class="bg-light p-2">
    <h6 class="d-flex align-items-center mb-2">
        <i class="bx bx-calendar-event text-primary me-2"></i>
        <span>{{ $row->meeting_name }}</span>
    </h6>
    <div class="mt-2">
        <p class="mb-1">
            <i class="bx bx-repeat me-2"></i>
            <span class="text-strong">Recurrence:</span> {{ $row->recurrence->label() }}
        </p>
        <span class="d-inline-flex align-items-center">
            <i class="{{ $row->is_print ? 'bx bx-printer text-success' : 'bx bx-printer text-danger' }} me-2"></i>
            <span>{{ $row->is_print ? 'Printable' : 'Cannot Print' }}</span>
        </span>
    </div>
</div>
