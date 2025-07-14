<div>

    @if ($row->name && $row->name !== 'N/A')
        <strong>{{ __('Name') }}:</strong> {{ $row->name }} <br>
    @endif

    @if ($row->designation && $row->designation !== 'N/A')
        <strong>{{ __('Designation') }}:</strong> {{ $row->designation }} <br>
    @endif

</div>
