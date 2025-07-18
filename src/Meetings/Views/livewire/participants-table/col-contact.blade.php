<div>

    @if($row->email && $row->email !== 'N/A')
    <strong>{{__('Email')}}:</strong> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a> <br>
@endif

@if($row->phone && $row->phone !== 'N/A')
    <strong>{{__('Mobile No')}}:</strong> <a href="tel:{{ $row->phone }}">{{ $row->phone }}</a> <br>
@endif

</div>
