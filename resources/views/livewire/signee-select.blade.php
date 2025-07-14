<select class="form-control" wire:model="selectedUserId" wire:change="selectSignee($event.target.value)">
    <option value="" hidden>{{__("Select Signee")}}</option>
    @foreach ($users as $user)
        <option value="{{ $user->id }}">{{ $user->name . ' (' . $user->mobile_no . ')' }}</option>
    @endforeach
</select>
