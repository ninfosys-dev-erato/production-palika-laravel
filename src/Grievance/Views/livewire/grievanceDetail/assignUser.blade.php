<form action="">
    <label for="assign0user">{{ __('grievance::grievance.change_assign_user') }}</label>
    <select dusk="grievance-grievanceDetail.assigned_user_id-field" id="assigned_to" name="grievanceDetail.assigned_user_id" class="form-control"
        wire:model="grievanceDetail.assigned_user_id">
        <option value="" hidden>{{ __('grievance::grievance.choose_user') }}</option>

        @foreach ($users as $user)
            <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
        @endforeach

    </select>

    <div class="mt-3">
        <button type="button" wire:confirm="Are you sure you want to assign the grievance?" wire:click="save"
            class="btn btn-primary">{{ __('grievance::grievance.save') }}</button>
    </div>
</form>
