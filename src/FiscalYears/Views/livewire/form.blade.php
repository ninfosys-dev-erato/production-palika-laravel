<form wire:submit.prevent="save">

    <div class="row">
        <div class='col-md-12'>
            <x-form.text-input label="{{ __('fiscalyears::fiscalyears.year') }}" id="year" name="fiscalYear.year"
                placeholder="{{ __('Insert fiscal year in format of 20**/0**') }}" />

        </div>
    </div>

    <div class="d-flex mt-3 gap-2">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('fiscalyears::fiscalyears.save') }}</button>
        <a href="{{ route('admin.setting.fiscal-years.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('Back')}}</a>
    </div>
</form>
