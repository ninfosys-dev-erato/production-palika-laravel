<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='title'>{{ __('ebps::ebps.title') }}</label>
                    <input wire:model='document.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('ebps::ebps.enter_title') }}">
                    <div>
                        @error('document.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='application_type'>{{ __('ebps::ebps.application_type') }}</label>
                    <select wire:model='document.application_type' name='application_type' class='form-control'>
                        <option value="">{{ __('ebps::ebps.select_application_type') }}</option>
                        @foreach ($applicationTypes as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('document.application_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ebps::ebps.save')}}</button>
        <a href="{{ route('admin.ebps.documents.index') }}" wire:loading.attr="disabled" class="btn btn-danger">{{__('ebps::ebps.back')}}</a>
    </div>
</form>
