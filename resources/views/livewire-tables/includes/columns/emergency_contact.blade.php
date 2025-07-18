<div>
    @if($contact_person && $contact_person !== 'N/A')
        <strong>{{__('Contact Person')}}:</strong> {{ $contact_person }} <br>
    @endif

    @if($address && $address !== 'N/A')
        <strong>{{__('Address')}}:</strong> {{ $address }} <br>
    @endif

    @if($contact_numbers && $contact_numbers !== 'N/A')
        <strong>{{__('Contact Number')}}:</strong> <a href="tel:{{ $contact_numbers }}">{{ $contact_numbers }}</a> <br>
    @endif
</div>