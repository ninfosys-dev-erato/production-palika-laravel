<div>

    @if($row->email && $row->email !== 'N/A')
    <strong>{{__('Email')}}:</strong> <a href="mailto:{{ $row->email }}">{{ $row->email }}</a> <br>
@endif

@if($row->mobile_no && $row->mobile_no !== 'N/A')
    <strong>{{__('Mobile No')}}:</strong> <a href="tel:{{ $row->mobile_no }}">{{ $row->mobile_no }}</a> <br>
@endif

</div>
