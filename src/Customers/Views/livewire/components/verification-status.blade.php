@if ($verified)
    <span class="bg-green-500 text-white px-2 py-1 rounded-full">{{__('Yes')}}</span>
@else
    <span class="bg-red-500 text-white px-2 py-1 rounded-full">{{__('No')}}</span>
@endif