<div>
    <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-between card-header">
            <h5 class="text-primary fw-bold mb-0">
                {{ $showFulfilledConditionForm
                    ? __('ejalas::ejalas.create_fulfilled_condition')
                    : __('ejalas::ejalas.fulfilled_condition_list') }}
            </h5>
        </div>

        <div>
            @perm('jms_judicial_management create')
                <button wire:click="toggleFulFilledConditionForm"
                    class="btn {{ $showFulfilledConditionForm ? 'btn-danger' : 'btn-info' }}">
                    <i class="bx {{ $showFulfilledConditionForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
                    {{ $showFulfilledConditionForm ? __('ejalas::ejalas.back') : __('ejalas::ejalas.create_fulfilled_condition') }}
                </button>
            @endperm
        </div>
    </div>

    @if (!$showFulfilledConditionForm)
        <livewire:ejalas.fulfilled_condition_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration" />
    @else
        <form wire:submit.prevent="save">
            <div class="card-body">
                <div class="row">
                    {{-- Complaint Number --}}
                    <div class="col-md-6 mb-3">
                        <label for="complaint_registration_id" class="form-label">
                            {{ __('ejalas::ejalas.complaint_no') }}
                        </label>
                        <input wire:model="fulfilledCondition.complaint_registration_id"
                            name="complaint_registration_id" type="text" class="form-control" readonly>
                    </div>

                    {{-- Fulfilling Party --}}
                    <div class="col-md-6 mb-3">
                        <label for="fulfilling_party" class="form-label">
                            {{ __('ejalas::ejalas.fulfilling_party') }}
                        </label>
                        <select wire:model="fulfilledCondition.fulfilling_party" name="party_name" class="form-select"
                            wire:change="getCondition()">
                            <option value="" hidden>
                                {{ __('ejalas::ejalas.select_a_party_name') }}
                            </option>
                            @forelse ($parties as $party)
                                <option value="{{ $party['id'] }}">
                                    {{ $party['name'] }} ({{ ucfirst($party['type']) }})
                                </option>
                            @empty
                                <option value="" disabled>{{ __('ejalas::ejalas.no_value_available') }}</option>
                            @endforelse
                        </select>
                        @error('fulfilledCondition.fulfilling_party')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Condition --}}
                    <div class="col-md-6 mb-3">
                        <label for="condition" class="form-label">
                            {{ __('ejalas::ejalas.condition') }}
                        </label>
                        <select wire:model="fulfilledCondition.condition" name="condition" class="form-select"
                            wire:change="getDeadline()">
                            <option value="" hidden>{{ __('ejalas::ejalas.select_a_condition') }}</option>
                            @forelse ($conditions as $condition)
                                <option value="{{ $condition->id }}">{{ $condition->detail }}</option>
                            @empty
                                <option disabled>No data to show</option>
                            @endforelse
                        </select>
                        @error('fulfilledCondition.condition')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Completion Date --}}
                    <div class="col-md-6 mb-3">
                        <label for="completion_date" class="form-label">
                            {{ __('ejalas::ejalas.condition_completion_date') }}
                        </label>
                        <input wire:model="fulfilledCondition.completion_date" name="completion_date"
                            id="completion_date" type="text" class="form-control nepali-date"
                            placeholder="{{ __('ejalas::ejalas.enter_completion_date') }}">
                        @error('fulfilledCondition.completion_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Completion Details --}}
                    <div class="col-md-6 mb-3">
                        <label for="completion_details" class="form-label">
                            {{ __('ejalas::ejalas.completion_details') }}
                        </label>
                        <textarea wire:model="fulfilledCondition.completion_details" name="completion_details" class="form-control"
                            placeholder="{{ __('ejalas::ejalas.enter_completion_details') }}" rows="5"></textarea>
                        @error('fulfilledCondition.completion_details')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Completion Proof --}}
                    <div class="col-md-6 mb-3">
                        <label for="completion_proof" class="form-label">
                            {{ __('ejalas::ejalas.completion_proof') }}
                        </label>
                        <textarea wire:model="fulfilledCondition.completion_proof" name="completion_proof" class="form-control"
                            placeholder="{{ __('ejalas::ejalas.enter_completion_proof') }}" rows="5"></textarea>
                        @error('fulfilledCondition.completion_proof')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Due Date --}}
                    <div class="col-md-6 mb-3">
                        <label for="due_date" class="form-label">
                            {{ __('ejalas::ejalas.condition_due_date') }}
                        </label>
                        <input wire:model="fulfilledCondition.due_date" name="due_date" type="text"
                            class="form-control" placeholder="{{ __('ejalas::ejalas.enter_due_date') }}" readonly>
                        @error('fulfilledCondition.due_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Entered By --}}
                    <div class="col-md-6 mb-3">
                        <label for="entered_by" class="form-label">
                            {{ __('ejalas::ejalas.entered_by') }}
                        </label>
                        <select wire:model="fulfilledCondition.entered_by" name="entered_by" class="form-select">
                            <option value="" hidden>{{ __('ejalas::ejalas.select_a_member') }}</option>
                            @forelse ($judicialEmployees as $id => $value)
                                <option value="{{ $id }}">{{ $value }}</option>
                            @empty
                                <option disabled>No data to show</option>
                            @endforelse
                        </select>
                        @error('fulfilledCondition.entered_by')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Entry Date --}}
                    <div class="col-md-6">
                        <label for="entry_date" class="form-label">
                            {{ __('ejalas::ejalas.entry_date') }}
                        </label>
                        <input wire:model="fulfilledCondition.entry_date" name="entry_date" type="text"
                            id="entry_date" class="form-control nepali-date"
                            placeholder="{{ __('ejalas::ejalas.enter_entry_date') }}">
                        @error('fulfilledCondition.entry_date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                    {{ __('ejalas::ejalas.save') }}
                </button>
            </div>
            <hr>

            {{-- Settlement Details Tables --}}
            <div class="d-flex flex-wrap mt-3">
                @if (!empty($allSettlementDetails))
                    @foreach ($allSettlementDetails as $type => $details)
                        <div class="flex-grow-1 me-2 mb-3" style="min-width: 300px; max-width: 48%;">
                            <h5 class="text-primary">{{ __('ejalas::ejalas.' . strtolower($type)) }}</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('ejalas::ejalas.detail') }}</th>
                                        <th>{{ __('ejalas::ejalas.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($details as $detail)
                                        <tr>
                                            <td>{{ $detail['detail'] ?? 'N/A' }}</td>
                                            <td>
                                                @if (isset($detail['status']) && $detail['status'])
                                                    <span class="badge bg-success">
                                                        {{ __('ejalas::ejalas.settled') }}</span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        {{ __('ejalas::ejalas.unsettled') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="text-center">
                                                {{ __('ejalas::ejalas.no_data_available') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                @else
                    <div class="w-100 text-center">
                        {{ __('ejalas::ejalas.no_data_available') }}
                    </div>
                @endif
            </div>

        </form>

    @endif
</div>
