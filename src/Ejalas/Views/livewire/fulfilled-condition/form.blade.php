<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6' wire:ignore>
                <div class='form-group'>
                    <label for='complaint_registration_id'
                        class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                    <select wire:model='fulfilledCondition.complaint_registration_id' id="complaint_registration_id"
                        name='complaint_registration_id' class="form-select" wire:change="getComplaintRegistration()">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_registration_number') }}</option>
                        @foreach ($complainRegistrations as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('courtNotice.complaint_registration_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='fulfilling_party' class="form-label">{{ __('ejalas::ejalas.fulfilling_party') }}</label>
                    <select wire:model='fulfilledCondition.fulfilling_party' name='fulfilling_party' class="form-select"
                        wire:change="getCondition()">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_party') }}</option>
                        @foreach ($parties as $party)
                            <option value="{{ $party->id }}">{{ $party->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('fulfilledCondition.fulfilling_party')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='condition' class="form-label">{{ __('ejalas::ejalas.condition') }}</label>
                    <select wire:model='fulfilledCondition.condition' name='condition' class="form-select"
                        wire:change="getDeadline()">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_condition') }}</option>
                        @forelse ($conditions as $condition)
                            <option value="{{ $condition->id }}">{{ $condition->detail }}</option>
                        @empty
                            <option disabled>No data to show</option>
                        @endforelse
                    </select>
                    <div>
                        @error('fulfilledCondition.condition')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='completion_date'
                        class="form-label">{{ __('ejalas::ejalas.condition_completion_date') }}</label>
                    <input wire:model='fulfilledCondition.completion_date' name='completion_date' id="completion_date"
                        type='text' class='form-control nepali-date'
                        placeholder="{{ __('ejalas::ejalas.enter_completion_date') }}">
                    <div>
                        @error('fulfilledCondition.completion_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='completion_details'
                        class="form-label">{{ __('ejalas::ejalas.completion_details') }}</label>
                    <textarea wire:model='fulfilledCondition.completion_details' name='completion_details' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_completion_details') }}" rows="5"></textarea>
                    <div>
                        @error('fulfilledCondition.completion_details')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='completion_proof'
                        class="form-label">{{ __('ejalas::ejalas.completion_proof') }}</label>
                    <textarea wire:model='fulfilledCondition.completion_proof' name='completion_proof' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_completion_proof') }}" rows="5"></textarea>
                    <div>
                        @error('fulfilledCondition.completion_proof')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='due_date' class="form-label">{{ __('ejalas::ejalas.condition_due_date') }}</label>
                    <input wire:model='fulfilledCondition.due_date' name='due_date' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_due_date') }}" readonly>
                    <div>
                        @error('fulfilledCondition.due_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='entered_by' class="form-label">{{ __('ejalas::ejalas.entered_by') }}</label>
                    <select wire:model='fulfilledCondition.entered_by' name='entered_by' class="form-select">
                        <option value="" hidden>{{ __('ejalas::ejalas.select_a_member') }}</option>
                        @forelse ($judicialMembers as $id => $value)
                            <option value="{{ $id }}">{{ $value }}</option>
                        @empty
                            <option disabled>No data to show</option>
                        @endforelse

                    </select>
                    {{-- <input wire:model='fulfilledCondition.entered_by' name='entered_by' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_entered_by') }}"> --}}
                    <div>
                        @error('fulfilledCondition.entered_by')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='entry_date' class="form-label">{{ __('ejalas::ejalas.entry_date') }}</label>
                    <input wire:model='fulfilledCondition.entry_date' name='entry_date' type='text' id="entry_date"
                        class='form-control nepali-date' placeholder="{{ __('ejalas::ejalas.enter_entry_date') }}">
                    <div>
                        @error('fulfilledCondition.entry_date')
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
        <a href="{{ route('admin.ejalas.fulfilled_conditions.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>

    <div class="d-flex justify-content-between gap-3 m-2">
        <div class="w-50">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('ejalas::ejalas.detail_complainer') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allSettlementDetails['Complainer'] ?? [] as $allSettlementDetail)
                        <tr>
                            <td>{{ $allSettlementDetail->detail }}</td>
                            <td>{{ $allSettlementDetail->is_settled ? 'Settled' : 'Unsettled' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">{{ __('No data available') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="w-50">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('ejalas::ejalas.detail_defender') }}</th>
                        <th>{{ __('Status') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($allSettlementDetails['Defender'] ?? [] as $allSettlementDetail)
                        <tr>
                            <td>{{ $allSettlementDetail->detail }}</td>
                            <td>{{ $allSettlementDetail->is_settled ? 'Settled' : 'Unsettled' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center">{{ __('No data available') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>





</form>
@script
    <script>
        $('#complaint_registration_id').select2();
        $('#complaint_registration_id').on('change', function(e) {
            let complaintId = $(this).val();
            @this.set('fulfilledCondition.complaint_registration_id', complaintId);
            @this.call('getComplaintRegistration'); // Call livewire function to get party details
        });
    </script>
@endscript
