<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label">{{ __('ejalas::ejalas.complaint_registration_id') }}</label>
                    <select wire:model='mediatorSelection.complaint_registration_id' name='complaint_registration_id'
                        class="form-select" id="complaint_registration_id">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_complaint') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('mediatorSelection.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='mediator_id' class="form-label">{{ __('ejalas::ejalas.mediator') }}</label>
                    <select wire:model='mediatorSelection.mediator_id' name='mediator_id' class="form-control">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_mediator') }}</option>
                        @foreach ($mediators as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('mediatorSelection.mediator_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='mediator_type' class="form-label">{{ __('ejalas::ejalas.mediator_type') }}</label>
                    <select wire:model='mediatorSelection.mediator_type' name='mediator_type' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_mediator_selection_type') }}
                        </option>
                        @foreach ($mediatorSelectionTypes as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('mediatorSelection.mediator_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='selection_date'
                        class="form-label">{{ __('ejalas::ejalas.mediator_selection_date') }}</label>
                    <input wire:model='mediatorSelection.selection_date' name='selection_date' id="selection_date"
                        type='string' class='form-control nepali-date'
                        placeholder="{{ __('ejalas::ejalas.enter_selection_date') }}">
                    <div>
                        @error('mediatorSelection.selection_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.mediator_selections.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>

@script
    <script>
        $(document).ready(function() {

            $('#complaint_registration_id').select2();
            $('#complaint_registration_id').on('change', function(e) {
                let complaintId = $(this).val();
                @this.set('mediatorSelection.complaint_registration_id', $(this).val())
            });
        });
    </script>
@endscript
