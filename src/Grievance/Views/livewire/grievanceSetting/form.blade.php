<form wire:submit.prevent="save">
    <div class="row">


        <div class="col-md-6">
            <x-form.select-input label="{{ __('grievance::grievance.grievance_assign') }}" id="grievance_assigned_to"
                name="grievanceSetting.grievance_assigned_to" :options="$users"
                placeholder="{{ __('grievance::grievance.choose_user') }}" />
        </div>
        <div class="col-md-6">
            <x-form.text-input type="number" min="0" label="{{ __('grievance::grievance.escalation_days') }}"
                id="escalation_days" name="grievanceSetting.escalation_days" />
        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        @perm('grievance_setting edit')
            <button type="submit" class="btn btn-primary"
                wire:loading.attr="disabled">{{ __('grievance::grievance.save') }}</button>
        @endperm
        <a href="{{ route('admin.grievance.setting') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('grievance::grievance.back') }}</a>
    </div>
</form>
