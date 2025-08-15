<div>
    <form wire:submit.prevent="save">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name" class="form-label">{{ __('ebps::ebps.name') }} <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('additionalForm.name') is-invalid @enderror"
                        id="name" wire:model="additionalForm.name" placeholder="{{ __('ebps::ebps.enter_name') }}">
                    @error('additionalForm.name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_id" class="form-label">{{ __('ebps::ebps.form_id') }}</label>
                    {{-- <input type="number" class="form-control @error('additionalForm.form_id') is-invalid @enderror"
                        id="form_id" wire:model="additionalForm.form_id"
                        placeholder="{{ __('ebps::ebps.enter_form_id') }}"> --}}
                    <select name="form_id" id="form_id" class="form-control" wire:model="additionalForm.form_id">
                        <option value="">{{ __('ebps::ebps.select_form') }}</option>
                        @foreach ($forms as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('additionalForm.form_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"
                wire:loading.attr="disabled">{{ __('ebps::ebps.save') }}</button>
            <a href="{{ route('admin.ebps.additional_form_settings.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
        </div>
    </form>
</div>
