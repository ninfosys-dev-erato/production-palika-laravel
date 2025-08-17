<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label">{{ __('ejalas::ejalas.complaint_registration') }}</label>
                    <select wire:model="disputeDeadline.complaint_registration_id" name="complaint_registration_id"
                        class="form-select select2-component @error('disputeDeadline.complaint_registration_id') is-invalid @enderror"
                        wire:change="getComplaintRegistration()" id="complaint_registration_id">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_registration_number') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <div>
                        @error('disputeDeadline.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="fiscal_year" class="form-label">
                    {{ __('ejalas::ejalas.fiscal_year') }}
                </label>
                <input type="text" class="form-control" value="{{ $complaintData['fiscal_year']['year'] ?? 'N/A' }}"
                    readonly>

            </div>

            <div class="col-md-6 mb-3">
                <label for="reg_date" class="form-label">
                    {{ __('ejalas::ejalas.complain_registration_date') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.reg_date" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="reg_date" class="form-label">
                    {{ __('ejalas::ejalas.priority') }}
                </label>
                <input type="text" class="form-control" value="{{ $complaintData['priority']['name'] ?? 'N/A' }}"
                    readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label for="dispute_matter_id" class="form-label">
                    {{ __('ejalas::ejalas.dispute_matter') }}
                </label>
                <input type="text" class="form-control"
                    value="{{ $complaintData['dispute_matter']['title'] ?? 'N/A' }}" readonly>


            </div>
            <div class="col-md-6 mb-3">
                <label for="claim request" class="form-label">
                    {{ __('ejalas::ejalas.claim_request') }}
                </label>
                <input type="text" class="form-control" wire:model="complaintData.claim_request" readonly>
            </div>


            <div class="col-md-6 mb-3">
                <label for="complainer_id" class="form-label">
                    {{ __('ejalas::ejalas.complainers') }}
                </label>
                @forelse ($complainers as $complainer)
                    <input type="text" class="form-control mb-2" value="{{ $complainer }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_complainer') }}"
                        readonly>
                @endforelse
            </div>

            <div class="col-md-6 mb-3">
                <label for="defender_id" class="form-label">
                    {{ __('ejalas::ejalas.defenders') }}
                </label>
                @forelse ($defenders as $defender)
                    <input type="text" class="form-control mb-2" value="{{ $defender }}" readonly>
                @empty
                    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_defender') }}"
                        readonly>
                @endforelse
            </div>




            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='registrar_id' class="form-label">{{ __('ejalas::ejalas.registrar') }}</label>

                    <select wire:model='disputeDeadline.registrar_id' name='registrar_id' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_an_employee_name') }}</option>
                        @foreach ($registerEmployees as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('disputeDeadline.registrar_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deadline_set_date'
                        class="form-label">{{ __('ejalas::ejalas.deadline_set_date') }}</label>
                    <input wire:model='disputeDeadline.deadline_set_date' id="deadline_set_date"
                        name='deadline_set_date' type='text' class='form-control nepali-date'
                        placeholder="{{ __('ejalas::ejalas.enter_deadline_set_date') }}">
                    <div>
                        @error('disputeDeadline.deadline_set_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='deadline_extension_period'
                        class="form-label">{{ __('ejalas::ejalas.deadline_extension_period') }}</label>
                    <input wire:model='disputeDeadline.deadline_extension_period' name='deadline_extension_period'
                        type='number' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_deadline_extension_period') }}">
                    <div>
                        @error('disputeDeadline.deadline_extension_period')
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
        <a href="{{ route('admin.ejalas.dispute_deadlines.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
@script
    <script>
        $(document).ready(function() {

            $('#complaint_registration_id').select2();
            $('#complaint_registration_id').on('change', function(e) {
                let complaintId = $(this).val();
                @this.set('disputeDeadline.complaint_registration_id', complaintId);
                @this.call('getComplaintRegistration');
            });
        });
    </script>
@endscript
