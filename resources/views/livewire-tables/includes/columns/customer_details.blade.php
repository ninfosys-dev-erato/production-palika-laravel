<div>
    @if ($name && $name !== 'N/A')
        <strong>{{ __('Name') }}:</strong> {{ $name }} <br>
    @endif

    @if ($email && $email !== 'N/A')
        <strong>{{ __('Email') }}:</strong> <a href="mailto:{{ $email }}">{{ $email }}</a> <br>
    @endif

    @if ($mobile_no && $mobile_no !== 'N/A')
        <strong>{{ __('Mobile No') }}:</strong> <a href="tel:{{ $mobile_no }}">{{ $mobile_no }}</a> <br>
    @endif
</div>