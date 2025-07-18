<div style="text-align: center;">
    @php
        $color = '';
        switch ($status) {
            case 'pending':
                $color = ' text-warning';
                break;
            case 'rejected':
                $color = ' text-danger';
                break;
            case 'sent for payment':
                $color = ' text-primary';
                break;
            case 'bill uploaded':
                $color = ' text-primary';
                break;
            case 'sent for approval':
                $color = ' text-success';
                break;
            case 'accepted':
                $color = ' text-success fw-bold';
                break;
            case 'unseen':
                $color = ' text-danger';
                break;
            case 'closed':
                $color = ' text-success';
                break;
            case 'replied':
                $color = ' text-primary';
                break;
            case 'investigating':
                $color = ' text-primary';
                break;
            case 'low':
                $color = ' text-primary';
                break;
            case 'medium':
                $color = ' text-warning';
                break;
            case 'high':
                $color = ' text-danger';
                break;
            case 'sent for renewal':
                $color = ' text-primary';
                break;
            default:
                $color = ' text-dark';
        }
    @endphp

    <span class="{{ $color }}">
        {{ __(ucfirst($status)) }}
    </span>
</div>
