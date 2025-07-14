<form wire:submit.prevent="save">
    <div class="row">
        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='service'>{{ __('digitalboard::digitalboard.enter_service_name') }}</label>
                <input dusk="digitalboard-service-field" wire:model='citizenCharter.service' name='service' type='text'
                    class="form-control {{ $errors->has('citizenCharter.service') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('citizenCharter.service') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.enter_service') }}">
                <div>
                    @error('citizenCharter.service')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group" wire:ignore>
                <label for="citizen_charter_branch" class="form-label">{{ __('digitalboard::digitalboard.select_branch') }}</label>
                <select dusk="digitalboard-citizenCharter.branch_id-field" id="citizen_charter_branch" name="citizenCharter.branch_id"
                    class="form-select select2-component {{ $errors->has('citizenCharter.service') ? 'is-invalid' : '' }}"
                    style="width: 100%;"
                    style="{{ $errors->has('citizenCharter.service') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    wire:model="citizenCharter.branch_id" required>
                    <option value="" disabled selected>
                        {{ __('digitalboard::digitalboard.select_branch') }}
                    </option>
                    @foreach ($branches as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach

                </select>
            </div>
            @error('citizenCharter.branch_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <div class="form-group">
                <label class="form-label" for="required_document">{{ __('digitalboard::digitalboard.required_document') }}</label>
                <textarea dusk="digitalboard-required_document-field" wire:model="citizenCharter.required_document" name="required_document"
                    class="form-control {{ $errors->has('citizenCharter.required_document') ? 'is-invalid' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.enter_required_document') }}"></textarea>
                @error('citizenCharter.required_document')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='amount'>{{ __('digitalboard::digitalboard.amount') }}</label>
                <input dusk="digitalboard-amount-field" wire:model='citizenCharter.amount' name='amount' class='form-control'
                    placeholder="{{ __('digitalboard::digitalboard.enter_amount') }}">
                <div>
                    @error('citizenCharter.amount')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6 mb-3'>
            <div class='form-group'>
                <label class="form-label" for='time'>{{ __('digitalboard::digitalboard.time') }}</label>
                <input dusk="digitalboard-time-field" wire:model='citizenCharter.time' name='time' type='text'
                    class="form-control {{ $errors->has('citizenCharter.time') ? 'is-invalid' : '' }}"
                    style="{{ $errors->has('citizenCharter.time') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                    placeholder="{{ __('digitalboard::digitalboard.enter_time') }}">
                <div>
                    @error('citizenCharter.time')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class='col-md-6'>
            <div class='form-group'>
                <label class="form-label" for='responsible_person'>{{ __('digitalboard::digitalboard.responsible_person') }}</label>
                <input dusk="digitalboard-responsible_person-field" wire:model='citizenCharter.responsible_person' name='responsible_person' type='text'
                    class='form-control' placeholder="{{ __('digitalboard::digitalboard.enter_responsible_person') }}">
                <div>
                    @error('citizenCharter.responsible_person')
                        <small class='text-danger'>{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="form-group" wire:ignore>
                <label for="citizen_charter_ward" class="form-label">{{ __('digitalboard::digitalboard.select_wards') }}</label>
                <select dusk="digitalboard-selectedWards-field" id="citizen_charter_ward" name="selectedWards" class="form-select select2-component" multiple
                    style="width: 100%;" wire:model="selectedWards">

                    @foreach ($wards as $value => $label)
                        <option value="{{ $value }}">{{ replaceNumbersWithLocale($label,true) }}</option>
                    @endforeach

                </select>
            </div>
            @error('wards')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class='col-md-12'>
            <div class="form-group">
                <div class="form-check mt-2">
                    <input dusk="digitalboard-canShowOnAdmin-field" class="form-check-input" type="checkbox" id="can_show_on_admin" wire:model="canShowOnAdmin">
                    <label class="form-check-label" for="can_show_on_admin" style="font-size: 0.95rem;">
                        {{ __('digitalboard::digitalboard.can_show_on_palika') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('digitalboard::digitalboard.save') }}</button>
        <a href="{{ route('admin.digital_board.citizen_charters.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('digitalboard::digitalboard.back') }}</a>
    </div>
</form>

@script
    <script>
        $(document).ready(function() {
            const branchSelect = $('#citizen_charter_branch');
            const wardSelect = $('#citizen_charter_ward');

            wardSelect.select2({
                placeholder: "{{ __('digitalboard::digitalboard.select_wards') }}"
            })

            wardSelect.on('change', function() {
                const selectedWards = $(this).val();
                @this.set('selectedWards', selectedWards)
            })

            branchSelect.select2()

            branchSelect.on('change', function() {
                const selectedBranch = $(this).val();
                @this.set('citizenCharter.branch_id', selectedBranch)
            })
        })
    </script>
@endscript
