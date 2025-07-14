<form wire:submit.prevent="save">
    <div class="row">
        <div class="col-md-12">
            <x-form.text-input label="{{ __('grievance::grievance.title') }}" id="title" name="grievanceType.title"
                dusk='title' />
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <x-form.checkbox-input id="is_ward" name="grievanceType.is_ward" :options="['is_ward' => __('grievance::grievance.grievance_is_for_the_ward')]" />
            </div>
        </div>
        <div class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-primary">{{ __('grievance::grievance.assign_role') }}</h5>
                </div>
                <div class="card-body">
                    <livewire:grievance.partial_grievance_type_role_manage :$grievanceType :$action
                        wire:model="selectedRoles" />
                </div>
            </div>
        </div>
        <div class="mt-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0 text-primary">{{ __('grievance::grievance.assign_department') }}</h5>
                </div>
                <div class="card-body">
                    <livewire:grievance.partial_grievance_type_department_manage :$grievanceType :$action
                        wire:model="selectedDepartments" />
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('grievance::grievance.save') }}</button>
        <a href="{{ route('admin.grievance.grievanceType.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('grievance::grievance.back') }}</a>
    </div>
</form>
