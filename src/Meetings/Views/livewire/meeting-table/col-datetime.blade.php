<div class="row g-1 text-muted">
    <div class="col-md-6 d-flex align-items-start">
        <i class="bx bx-calendar text-primary me-2"></i>
        <div>
            <strong class="small">Start:</strong>
            <br>
            <span class="small">{{ \Carbon\Carbon::parse($row->en_start_date)->format('Y-m-d') }}</span>
            @if(\Carbon\Carbon::parse($row->en_start_date)->format(format: 'H:i:s') !== '00:00:00')
                <br>
                <small>Time: {{ \Carbon\Carbon::parse($row->en_start_date)->format('H:i') }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-6 d-flex align-items-start">
        <i class="bx bx-calendar-check text-success me-2"></i>
        <div>
            <strong class="small">End:</strong>
            <br>
            <span class="small">{{ \Carbon\Carbon::parse($row->en_end_date)->format('Y-m-d') }}</span>
            @if(\Carbon\Carbon::parse($row->en_end_date)->format('H:i:s') !== '00:00:00')
                <br>
                <small>Time: {{ \Carbon\Carbon::parse($row->en_end_date)->format('H:i') }}</small>
            @endif
        </div>
    </div>
    <div class="col-md-12 d-flex align-items-start">
        <i class="bx bx-calendar-exclamation text-danger me-2"></i>
        <div>
            <strong class="small">Recurrence:</strong>
            <br>
            <span class="small">{{ \Carbon\Carbon::parse($row->en_recurrence_end_date)->format('Y-m-d') }}</span>
            @if(\Carbon\Carbon::parse($row->en_recurrence_end_date)->format('H:i:s') !== '00:00:00')
                <small>Time: {{ \Carbon\Carbon::parse($row->en_recurrence_end_date)->format('H:i') }}</small>
            @endif
        </div>
    </div>
</div>
