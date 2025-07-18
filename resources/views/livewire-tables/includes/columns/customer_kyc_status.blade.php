<div style="text-align: center;">
    @php
        $kyc = $customer->kyc ?? null; 
        $status = $kyc?->status->name ?? null; 
        $color = '';
        
        if (is_null($status)) {
            $color = 'text-muted'; 
            $statusText = 'Not Available'; 
        } else {
            switch ($status) {
                case 'PENDING':
                    $color = 'text-warning';
                    break;
                case 'ACCEPTED':
                    $color = 'text-success';
                    $statusText = 'VERIFIED';
                    break;
                case 'REVIEWING':
                    $color = 'text-primary';
                    break;
                case 'REJECTED':
                    $color = 'text-danger';
                    break;
                default:
                    $color = 'text-dark';
            }
            $statusText = $statusText ?? ucfirst($status);
        }
    @endphp

    <span class="{{ $color }}">
        {{ $statusText }}
    </span>
</div>