<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label">{{ __('ejalas::ejalas.complaint_registration_id') }}</label>
                    <select wire:model='witnessesRepresentative.complaint_registration_id'
                        name='complaint_registration_id' class="form-select" id="complaint_registration_id">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_complaint') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    {{-- <input wire:model='witnessesRepresentative.complaint_registration_id'
                        name='complaint_registration_id' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_complaint_registration_id') }}"> --}}
                    <div>
                        @error('witnessesRepresentative.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='name' class="form-label">{{ __('ejalas::ejalas.witness_name') }}</label>
                    <input wire:model='witnessesRepresentative.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_name') }}">
                    <div>
                        @error('witnessesRepresentative.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label for='address' class="form-label">{{ __('ejalas::ejalas.witness_address') }}</label>
                    <input wire:model='witnessesRepresentative.address' name='address' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_address') }}">
                    <div>
                        @error('witnessesRepresentative.address')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mt-4'>
                <div class='form-group'>
                    <label for='is_first_party' class="form-label">{{ __('ejalas::ejalas.is_first_party') }}</label>
                    <input wire:model='witnessesRepresentative.is_first_party' name='is_first_party' type='checkbox'
                        class="form-check-input border-dark p-2 mt-1" placeholder="{{ __('ejalas::ejalas.enter_is_first_party') }}">
                    <div>
                        @error('witnessesRepresentative.is_first_party')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.witnesses_representatives.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>

<script>
    $(document).ready(function () {
        $('#complaint_registration_id').select2();
        $('#complaint_registration_id').on('change', function (e) {
            let complaintId = $(this).val();
            @this.set('witnessesRepresentative.complaint_registration_id', $(this).val())
        });
    })
</script>