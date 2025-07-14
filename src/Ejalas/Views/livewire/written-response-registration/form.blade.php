<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='response_registration_no'
                        class="form-label">{{ __('ejalas::ejalas.response_registration_no') }}</label>
                    <input wire:model='writtenResponseRegistration.response_registration_no'
                        name='response_registration_no' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_response_registration_no') }}" readonly>
                    <div>
                        @error('writtenResponseRegistration.response_registration_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label">{{ __('ejalas::ejalas.complaint_registration_id') }}</label>
                    <select wire:model='writtenResponseRegistration.complaint_registration_id'
                        id="complaint_registration_id"
                        class="form-select form-select-md p-2  @error('complaint_registration_id') is-invalid @enderror"
                        name='complaint_registration_id' wire:change="getComplaintRegistration()" required>
                        <option value="" hidden>{{ __('ejalas::ejalas.select_registration_number') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('writtenResponseRegistration.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label for="complainer_id" class="form-label">{{ __('ejalas::ejalas.complainers') }}</label>
                @forelse ($complainers as $complainer)
                    <input type="text" class="form-control mb-2" value="{{ $complainer }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_complainer') }}"
                        readonly>
                @endforelse
            </div>

            <div class="col-md-6 mb-3">
                <label for="defender_id" class="form-label">{{ __('ejalas::ejalas.defenders') }}</label>
                @forelse ($defenders as $defender)
                    <input type="text" class="form-control mb-2" value="{{ $defender }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_defender') }}"
                        readonly>
                @endforelse
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='registration_date'
                        class="form-label">{{ __('ejalas::ejalas.registration_date') }}</label>
                    <input wire:model='writtenResponseRegistration.registration_date' id="registration_date"
                        name='registration_date' type='string' class='form-control'>
                    <div>
                        @error('writtenResponseRegistration.registration_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fee_amount' class="form-label">{{ __('ejalas::ejalas.fee_amount') }}</label>
                    <input wire:model='writtenResponseRegistration.fee_amount' name='fee_amount' type='number'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_fee_amount') }}">
                    <div>
                        @error('writtenResponseRegistration.fee_amount')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fee_receipt_no' class="form-label">{{ __('ejalas::ejalas.fee_receipt_no') }}</label>
                    <input wire:model='writtenResponseRegistration.fee_receipt_no' name='fee_receipt_no' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_fee_receipt_no') }}">
                    <div>
                        @error('writtenResponseRegistration.fee_receipt_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fee_paid_date' class="form-label">{{ __('ejalas::ejalas.fee_paid_date') }}</label>
                    <input wire:model='writtenResponseRegistration.fee_paid_date' id="fee_paid_date"
                        name='fee_paid_date' type='string' class='form-control'>
                    <div>
                        @error('writtenResponseRegistration.fee_paid_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='description' class="form-label">{{ __('ejalas::ejalas.description') }}</label>
                    <textarea wire:model='writtenResponseRegistration.description' name='description' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_description') }}" rows="5"></textarea>
                    <div>
                        @error('writtenResponseRegistration.description')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='claim_request' class="form-label">{{ __('ejalas::ejalas.claim_request') }}</label>
                    <textarea wire:model='writtenResponseRegistration.claim_request' name='claim_request' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_claim_request') }}" rows="5"></textarea>
                    <div>
                        @error('writtenResponseRegistration.claim_request')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mt-3">

                <div class="divider divider-primary text-start text-primary">
                    <div class="divider-text fw-bold fs-6">
                        {{ __('ejalas::ejalas.eligibility_indicators_for_registration') }}
                    </div>
                </div>


                <ol class="list-unstyled">
                    @foreach ($registrationIndicators as $id => $value)
                        <li class="row mb-3 align-items-center">
                            <div class="col-md-9">
                                <label class="fw-bold mb-0">{{ $value }}</label>
                            </div>
                            <div class="col-md-3 d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live="selectedIndicators.{{ $id }}"
                                        id="full_{{ $id }}" value="पूरा भएको">
                                    <label class="form-check-label" for="full_{{ $id }}">पूरा
                                        भएको</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live="selectedIndicators.{{ $id }}"
                                        id="not_full_{{ $id }}" value="पूरा नभएको">
                                    <label class="form-check-label" for="not_full_{{ $id }}">पूरा
                                        नभएको</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio"
                                        wire:model.live="selectedIndicators.{{ $id }}"
                                        id="not_applicable_{{ $id }}" value="लागु नहुने">
                                    <label class="form-check-label" for="not_applicable_{{ $id }}">लागु
                                        नहुने</label>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ol>
            </div>

            <hr>
            <div class="d-flex justify-content-end">
                <div class='col-md-4 mb-3'>
                    <div class='form-group'>
                        <label for='status' class="form-label">{{ __('ejalas::ejalas.status') }}</label>
                        <select wire:model='writtenResponseRegistration.status' name='status' class='form-select'
                            disabled>
                            <option value="Rejected">{{ __('ejalas::ejalas.rejected') }}</option>
                            <option value="Approved">{{ __('ejalas::ejalas.approved') }}</option>
                        </select>
                        <div>
                            @error('writtenResponseRegistration.status')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
        <a href="{{ route('admin.ejalas.written_response_registrations.index') }}" class="btn btn-danger"
            wire:loading.attr="disabled">{{ __('ejalas::ejalas.back') }}</a>
    </div>

    {{-- <style>
        .select2-selection {
            height: calc(2.25rem + 2px) !important;
            /* Matches the default height of a Bootstrap input */
            padding: 0.375rem 0.75rem;
            /* Matches the padding */
            font-size: 1rem;
            /* Matches the font size */
            border-radius: 0.375rem;
            /* Matches the border radius */
            border: 1px solid #ced4da;
            /* Matches the border color */
        }
    </style> --}}
</form>


<script>
    $(document).ready(function() {
        $('#complaint_registration_id').select2();
        $('#complaint_registration_id').on('change', function(e) {
            let complaintId = $(this).val();
            @this.set('writtenResponseRegistration.complaint_registration_id', $(this).val())
            @this.call('getComplaintRegistration'); // Call livewire function to get party details
        });

        $('#fee_paid_date').nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        }).on('dateSelect', function() {
            let nepaliDate = $(this).val();
            @this.set('writtenResponseRegistration.fee_paid_date', nepaliDate);
        });
        $('#registration_date').nepaliDatePicker({
            dateFormat: '%y-%m-%d',
            closeOnDateSelect: true,
        }).on('dateSelect', function() {
            let nepaliDate = $(this).val();
            @this.set('writtenResponseRegistration.registration_date', nepaliDate);
        });
    })
</script>
