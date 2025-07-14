@php
    function getStatusColo($status)
    {
        switch (strtolower($status)) {
            case 'accepted':
                return 'bg-success text-white';
            case 'pending':
                return 'bg-warning text-dark';
            case 'rejected':
                return 'bg-danger text-white';
            default:
                return 'bg-secondary text-white';
        }
    }
@endphp
<div class="row mt-5">
    <div class="col-md-12">
        <div class="card mt-3">
            <div class="card-header text-white">
                <h4 class="align-items-left mb-0">
                    <span>{{ __('KYC Verification Logs') }}</span>
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="timeline p-4">
                    @foreach ($groupedLogs as $date => $logs)
                        <div class="timeline-item position-relative mb-4 pb-4"
                            style="border-left: 2px solid #dee2e6; padding-left: 20px;">
                            <div class="position-absolute"
                                style="left: -8px; top: 0; width: 16px; height: 16px; background-color: #007bff; border-radius: 50%;">
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-light text-dark">
                                    {{ \Carbon\Carbon::parse($date)->format('M d, Y') }}
                                </span>
                            </div>
                            <div class="card border shadow-sm bg-light" style="border-radius: 10px;">
                                <div class="card-body">
                                    @foreach ($logs as $log)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small">{{ $log->created_at->format('h:i A') }} -
                                                    {{ $log->updated_by }}</span>
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <span
                                                    class="badge me-2 {{ getStatusColo($log->old_status) }}">{{ $log->old_status }}</span>
                                                <span class="text-muted">→</span>
                                                <span
                                                    class="badge ms-2 {{ getStatusColo($log->new_status) }}">{{ $log->new_status }}</span>
                                            </div>
                                            <p class="card-text small mb-0">{!! nl2br(e($log->remarks)) !!}</p>
                                        </div>
                                        @if (!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
