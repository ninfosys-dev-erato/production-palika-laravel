<div>
@if($showForm)
<form wire:submit.prevent="save">
    <!-- Registration Details Card -->
    <div class="card mb-3 mt-3">
        <div class="card-header">
            <div class="divider divider-primary text-start text-primary">
                <div class="divider-text fw-bold fs-6">
                    {{ __('ejalas::ejalas.dispute_registration_details') }}
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
           
                <div class="col-md-6 mb-3">
                    <label for="complaint_registration_id" class="form-label">
                        {{ __('ejalas::ejalas.complaint_registration_no') }}
                    </label>
                   <input type="text" class="form-control"
                        value="{{ $complaintRegistration->reg_no}}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="fiscal_year" class="form-label">
                        {{ __('ejalas::ejalas.fiscal_year') }}
                    </label>
                    <input type="text" class="form-control"
                        value="{{ $complaintRegistration->fiscalYear?->year }}" readonly>

                </div>

                <div class="col-md-6 mb-3">
                    <label for="reg_date" class="form-label">
                        {{ __('ejalas::ejalas.complain_registration_date') }}
                    </label>
                    <input type="text" class="form-control" readonly value="{{ $complaintRegistration->reg_date }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="reg_date" class="form-label">
                        {{ __('ejalas::ejalas.priority') }}
                    </label>
                    <input type="text" class="form-control"
                        value="{{ $complaintRegistration->priority?->name }}" readonly>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="dispute_matter_id" class="form-label">
                        {{ __('ejalas::ejalas.dispute_matter') }}
                    </label>
                    <input type="text" class="form-control"
                        value="{{ $complaintRegistration->disputeMatter?->title }}" readonly>

                </div>
                <div class="col-md-6 mb-3">
                    <label for="claim request" class="form-label">
                        {{ __('ejalas::ejalas.claim_request') }}
                    </label>
                    <input type="text" class="form-control" value="{{ $complaintRegistration->claim_request }}" readonly>
                </div>


                <div class="col-md-6 mb-3">
                    <label for="complainer_id" class="form-label">
                        {{ __('ejalas::ejalas.complainers') }}
                    </label>


@forelse ($complaintRegistration->complainers as $complainer)
    <input type="text" class="form-control mb-2" value="{{ $complainer->name }}" readonly>
@empty
    <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_complainer') }}" readonly>
@endforelse


                </div>

                <div class="col-md-6 mb-3">
                    <label for="defender_id" class="form-label">
                        {{ __('ejalas::ejalas.defenders') }}
                    </label>
@forelse ($complaintRegistration->defenders as $defender)
    <input type="text" class="form-control mb-2" value="{{ $defender->name }}" readonly>
@empty
  <input type="text" class="form-control mb-2" value="{{ __('ejalas::ejalas.no_defender') }}"
                            readonly>
@endforelse

                </div>

                <!-- Registrar Employee Name -->
                <div class="col-md-6 mb-3">
                    <label for="registrar_id" class="form-label">
                        {{ __('ejalas::ejalas.registrar_employee_name') }}
                    </label>
                    <select wire:model="disputeRegistrationCourt.registrar_id" name="registrar_id" class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_an_employee_name') }}</option>
                        @foreach ($registerEmployees as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    @error('disputeRegistrationCourt.registrar_id')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-3" wire:ignore>
                    <label for="registrar_id" class="form-label">
                        {{ __('ejalas::ejalas.decision_date') }}
                    </label>
                    <input wire:model="disputeRegistrationCourt.decision_date" id="decision_date" name="decision_date"
                        class="form-control nepali-date" type="text">
                    </input>
                    @error('disputeRegistrationCourt.decision_date')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- Dispute Conditions Card -->
    <div class="card mb-3">
        <div class="card-header">
            <div class="divider divider-primary text-start text-primary">
                <div class="divider-text fw-bold fs-6">
                    {{ __('ejalas::ejalas.dispute_conditions') }}
                </div>
            </div>

        </div>
        <div class="card-body">
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
                                    name="indicator_{{ $id }}"
                                    id="full_{{ $id }}" value="पूरा भएको">
                                <label class="form-check-label" for="full_{{ $id }}">पूरा भएको</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    wire:model.live="selectedIndicators.{{ $id }}"
                                    name="indicator_{{ $id }}"
                                    id="not_full_{{ $id }}" value="पूरा नभएको">
                                <label class="form-check-label" for="not_full_{{ $id }}">पूरा नभएको</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                    wire:model.live="selectedIndicators.{{ $id }}"
                                    name="indicator_{{ $id }}"
                                    id="not_applicable_{{ $id }}" value="लागु नहुने" >
                                <label class="form-check-label" for="not_applicable_{{ $id }}">लागु
                                    नहुने</label>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ol>



            <hr class="my-1">
            <div class="d-flex justify-content-end align-items-center">
                <div class="col-4">
                    <label for="complaint_registration_status">
                        {{ __('ejalas::ejalas.complaint_registration_status') }}
                    </label>
                    <select wire:model="disputeRegistrationCourt.status" name="status" class="form-control"
                        disabled>
                        <option value="rejected">{{ __('ejalas::ejalas.rejected') }}</option>
                        <option value="approved">{{ __('ejalas::ejalas.approved') }}</option>
                    </select>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                    id="saveAllBtn">{{ __('ejalas::ejalas.save') }}</button>
                {{-- <a href="{{ route('admin.ejalas.dispute_registration_courts.index') }}" wire:loading.attr="disabled"
                    class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a> --}}
            </div>
        </div>

    </div>

</form>
@else

<div class="card mb-3 mt-3">
    <div class="card-header">
        <div class="divider divider-primary text-start text-primary">
            <div class="divider-text fw-bold fs-6">
                {{ __('ejalas::ejalas.dispute_registration_court_details') }}
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('ejalas::ejalas.complaint_registration_no') }}</th>
                        <th>{{ __('ejalas::ejalas.registrar_employee_name') }}</th>
                        <th>{{ __('ejalas::ejalas.decision_date') }}</th>
                        <th>{{ __('ejalas::ejalas.status') }}</th>
                        <th>{{ __('ejalas::ejalas.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $complaintRegistration->reg_no }}</td>
                        <td>{{ $disputeRegistrationCourt->judicialEmployee?->name ?? '-' }}</td>
                        <td>{{ $disputeRegistrationCourt->decision_date ?? '-' }}</td>
                        <td>
             {{ __('ejalas::ejalas.' . ($disputeRegistrationCourt->status ?? '')) ?: '-' }}

                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-primary btn-sm me-1" wire:click="edit">
                                    <i class="bx bx-edit me-1"></i>
                                 
                                </button>
                                  
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endif
</div>

@script
    <script>
        $(document).ready(function() {



            $('#complaint_registration_id').select2();
            $('#complaint_registration_id').on('change', function(e) {
                let complaintId = $(this).val();
                @this.set('disputeRegistrationCourt.complaint_registration_id', complaintId);
                @this.call('getComplaintRegistration'); // Call the Livewire function manually
            });
            // Handle Livewire updates
            Livewire.hook('message.processed', (message, component) => {
                $('#complaint_registration_id').select2('destroy');
                $('#complaint_registration_id').select2();
            });

        });
    </script>
@endscript
