<form wire:submit.prevent="save">

    <div class="row">
        <div class='col-md-6'>
            <x-form.text-input label="{{ __('employees::employees.title') }}" id="title" name="branch.title" />

        </div>
        <div class='col-md-6'>
            <x-form.text-input label="{{ __('employees::employees.title_en') }}" id="title_en" name="branch.title_en" />
        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('employees::employees.save') }}</button>
        <a href="{{ route('admin.employee.branch.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('employees::employees.back') }}</a>
    </div>
</form>
