<div>
    @if ($row->email && $row->email !== 'N/A')
        <strong>{{ __('employees::employees.email') }}:</strong> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a> <br>
    @endif

    @if ($row->phone && $row->phone !== 'N/A')
        <strong>{{ __('employees::employees.mobile_no') }}:</strong> <a href="tel:{{ $row->phone }}">{{ $row->phone }}</a> <br>
    @endif
</div>