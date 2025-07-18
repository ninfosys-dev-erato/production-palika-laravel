<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('ejalas::ejalas.ejalashdisputemattertitle') }}</label>
                    <input wire:model='disputeMatter.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_dispute_matter_title') }}">
                    <div>
                        @error('disputeMatter.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='dispute_area_id'>{{ __('ejalas::ejalas.dispute_area') }}</label>
                    {{-- <input wire:model='disputeMatter.dispute_area_id' name='dispute_area_id' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_dispute_area_id') }}"> --}}
                    <select wire:model='disputeMatter.dispute_area_id' name='dispute_area_id' type='text'
                        class='form-control'>
                        <option value=""hidden>{{ __('ejalas::ejalas.select_dispute_area') }}</option>
                        @foreach ($disputeAreas as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('disputeMatter.dispute_area_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.dispute_matters.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
