@php
    use Src\Ejalas\Enum\RouteName;
@endphp
<div>
    <div class="card mt-2">
        <div class="card-body">
            <form wire:submit.prevent="save" id="form1">
                <div class="divider divider-primary text-start text-primary">
                    <div class="divider-text fw-bold fs-6">
                        {{ __('ejalas::ejalas.registration_details') }}
                    </div>
                </div>

                <div class="row">
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='fiscal_year_id' class="form-label">{{ __('ejalas::ejalas.fiscal_year') }}</label>
                            <select wire:model='complaintRegistration.fiscal_year_id' name='fiscal_year_id'
                                type='text' class='form-control'>
                                <option value="" hidden>{{ __('ejalas::ejalas.select_a_fiscal_year') }}</option>
                                @foreach ($fiscalYears as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('complaintRegistration.fiscal_year_id')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='reg_no' class="form-label">{{ __('ejalas::ejalas.reg_no') }}</label>
                            <input wire:model='complaintRegistration.reg_no' name='reg_no' type='text'
                                class='form-control' placeholder="{{ __('ejalas::ejalas.enter_reg_no') }}" readonly>
                            <div>
                                @error('complaintRegistration.reg_no')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='old_reg_no' class="form-label">{{ __('ejalas::ejalas.old_reg_no') }}</label>
                            <input wire:model='complaintRegistration.old_reg_no' name='old_reg_no' type='text'
                                class='form-control' placeholder="{{ __('ejalas::ejalas.enter_old_reg_no') }}">
                            <div>
                                @error('complaintRegistration.old_reg_no')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='reg_date' class="form-label">{{ __('ejalas::ejalas.reg_date') }}</label>
                            <input wire:model='complaintRegistration.reg_date' name='reg_date' type="text"
                                id="reg_date" class='form-control nepali-date'
                                placeholder="{{ __('ejalas::ejalas.enter_reg_date') }}">
                            <div>
                                @error('complaintRegistration.reg_date')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='reg_address'
                                class="form-label">{{ __('ejalas::ejalas.place_of_registration') }}</label>
                            {{-- <input wire:model='complaintRegistration.reg_address' name='reg_address' type='text'
                                class='form-control' placeholder="{{ __('ejalas::ejalas.enter_reg_address') }}"> --}}
                            <select wire:model="complaintRegistration.reg_address" class="form-select"
                                wire:change="checkRegAddress">
                                <option value=""hidden>{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($placeOfRegistration as $value)
                                    <option value="{{ $value->value }}">{{ $value->value }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('complaintRegistration.reg_address')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if ($from == RouteName::ReconciliationCenter->value || $showField)
                        <div class='col-md-6 mb-3'>
                            <div class='form-group'>
                                <label for='reconciliation_center'
                                    class="form-label">{{ __('ejalas::ejalas.reconciliation_center') }}</label>
                                <select wire:model='complaintRegistration.reconciliation_center_id'
                                    name='reconciliation_center_id' type='text' class='form-control'>
                                    <option value="" hidden>{{ __('ejalas::ejalas.select_a_option') }}</option>
                                    @foreach ($reconciliationCenters as $id => $value)
                                        <option value="{{ $id }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('complaintRegistration.reconciliation_center_id')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($showField && $from == RouteName::General->value)
                        <div class='col-md-6 mb-3'>
                            <div class='form-group'>
                                <label for='reg_address'
                                    class="form-label">{{ __('ejalas::ejalas.reconciliation_reg_no') }}</label>
                                <input wire:model='complaintRegistration.reconciliation_reg_no'
                                    name='reconciliation_reg_no' type='text' class='form-control'
                                    placeholder="{{ __('ejalas::ejalas.enter_reconciliation_reg_no') }}">
                            </div>
                        </div>
                    @endif
                </div>
            </form>
        </div>
    </div>



    <div class="card mt-5">
        <div class="card-header d-flex justify-content-between">
            <div class="d-flex justify-content-between card-header">
                <h5 class="text-primary fw-bold mb-0">{{ __('ejalas::ejalas.complainer_details_list') }}</h5>
            </div>
            <div>
                @perm('parties create')
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal"><i
                            class="bx bx-plus"></i>
                        {{ __('ejalas::ejalas.add_complainer_details') }}</button>
                @endperm
            </div>
        </div>
        <div class="card-body">
            <livewire:ejalas.party_table theme="bootstrap-4" :complainer_reg_no="$complaintRegistration->reg_no" :type="'Complainer'" />
        </div>



        <div class="modal fade" id="indexModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">
                            {{ __('ejalas::ejalas.manage_complainer_details') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:ejalas.party_form :action="App\Enums\Action::CREATE" :reg_no="$complaintRegistration->reg_no" :type="'Complainer'"
                            :isModal="true" />
                    </div>
                </div>
            </div>
        </div>


    </div>



    <div class="card mt-5">
        <div class="card-header  d-flex justify-content-between">
            <div class="d-flex justify-content-between card-header">
                <h5 class="text-primary fw-bold mb-0">{{ __('ejalas::ejalas.defender_details_list') }}</h5>
            </div>
            <div>
                @perm('parties create')
                    <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#indexModal-defender"><i
                            class="bx bx-plus"></i>
                        {{ __('ejalas::ejalas.add_defender_details') }}</button>
                @endperm
            </div>
        </div>
        <div class="card-body">
            <livewire:ejalas.party_table theme="bootstrap-4" :complainer_reg_no="$complaintRegistration->reg_no" :type="'Defender'" />
        </div>




        <div class="modal fade" id="indexModal-defender" tabindex="-1" aria-labelledby="ModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">
                            {{ __('ejalas::ejalas.manage_defender_details') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="resetForm()"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <livewire:ejalas.party_form :action="App\Enums\Action::CREATE" :reg_no="$complaintRegistration->reg_no" :type="'Defender'"
                            :isModal="true" />
                    </div>
                </div>
            </div>
        </div>



    </div>

    <div class="card mt-2">
        <div class="card-body">
            <form id="form2" wire:submit.prevent="save">
                <div class="divider divider-primary text-start text-primary">
                    <div class="divider-text fw-bold fs-6">
                        {{ __('ejalas::ejalas.complaint_details') }}
                    </div>
                </div>
                <div class="row">
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='priority' class="form-label">{{ __('ejalas::ejalas.priority_type') }}</label>
                            <select wire:model='complaintRegistration.priority_id' name='priority_id' type='text'
                                class='form-control'>
                                <option value="" hidden>{{ __('ejalas::ejalas.select_a_priority') }}</option>
                                @foreach ($priorities as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>

                            <div>
                                @error('complaintRegistration.priority_id')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='dispute'
                                class="form-label">{{ __('ejalas::ejalas.dispute_matter') }}</label>
                            <select wire:model='complaintRegistration.dispute_matter_id' name='dispute_matter_id'
                                type='text' class='form-control'>
                                <option value="" hidden>{{ __('ejalas::ejalas.select_a_dispute') }}</option>
                                @foreach ($disputes as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                            <div>
                                @error('complaintRegistration.dispute_matter_id')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-12 mb-3'>
                        <div class='form-group'>
                            <label for='subject'
                                class="form-label">{{ __('ejalas::ejalas.additional_subject') }}</label>
                            <input wire:model='complaintRegistration.subject' name='subject' type='text'
                                class='form-control' placeholder="{{ __('ejalas::ejalas.enter_subject') }}">
                            <div>
                                @error('complaintRegistration.subject')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-12 mb-3'>
                        <div class='form-group' class="form-label">
                            <label for='description'
                                class="form-label">{{ __('ejalas::ejalas.detailed_description') }}</label>
                            <textarea wire:model='complaintRegistration.description' name='description' type='text' class='form-control'
                                placeholder="{{ __('ejalas::ejalas.enter_description') }}"rows="5"></textarea>
                            <div>
                                @error('complaintRegistration.description')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-12 mb-3'>
                        <div class='form-group' class="form-label">
                            <label for='claim_request'
                                class="form-label">{{ __('ejalas::ejalas.claim_request') }}</label>
                            <textarea wire:model='complaintRegistration.claim_request' name='claim_request' type='text' class='form-control'
                                placeholder="{{ __('ejalas::ejalas.enter_claim_request') }}"rows="5"></textarea>
                            <div>
                                @error('complaintRegistration.claim_request')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                        id="saveAllBtn">{{ __('ejalas::ejalas.save') }}</button>
                    <a href="{{ route('admin.ejalas.complaint_registrations.index') }}" wire:loading.attr="disabled"
                        class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                $('#indexModal').modal('hide');
                $('#indexModal-defender').modal('hide');
                $('.modal-backdrop').remove();
            });
        });
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('open-modal', () => {
                var modal = new bootstrap.Modal(document.getElementById('indexModal'));
                modal.show();
            });
        });


        $('#indexModal, #indexModal-defender').on('hidden.bs.modal', function() {
            Livewire.dispatch('reset-form');
            // Remove any inline styles or classes added by Bootstrap that might affect scrolling
            $('body').removeClass('modal-open').css({
                'overflow': '',
                'padding-right': ''
            });
        });


        document.addEventListener('livewire:initialized', () => {
            Livewire.on('close-modal', () => {
                $('#indexModal').modal('hide');
                $('#indexModal-defender').modal('hide');
            });
        });
    </script>
</div>


@script
    <script>
        document.getElementById('saveAllBtn').addEventListener('click', function(e) {
            e.preventDefault();
            @this.call('save');
        });

        $(document).ready(function() {

            @this.call('refreshFetchedParties'); // Call livewire function to get party details

            // $('#reg_date').nepaliDatePicker({
            //     dateFormat: '%y-%m-%d',
            //     closeOnDateSelect: true,
            // }).on('dateSelect', function() {
            //     let nepaliDate = $(this).val();
            //     @this.set('complaintRegistration.reg_date', nepaliDate);
            // });
        });
    </script>
@endscript
