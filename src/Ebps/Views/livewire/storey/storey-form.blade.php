<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('ebps::ebps.title') }}</label>
                    <input wire:model='storey.title' name='title' type='text'
                        class="form-control {{ $errors->has('storey.title') ? 'is-invalid' : '' }}"
                        style="{{ $errors->has('storey.title') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                        placeholder="{{ __('ebps::ebps.enter_title') }}">
                    <div>
                        @error('storey.title')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{__('ebps::ebps.save')}}</button>
        <a href="{{ route('admin.ebps.storeys.index') }}" wire:loading.attr="disabled" class="btn btn-danger">{{__('ebps::ebps.back')}}</a>
    </div>
</form>
