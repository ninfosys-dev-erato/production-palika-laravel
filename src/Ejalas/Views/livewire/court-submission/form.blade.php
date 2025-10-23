<div>

    <div class="d-flex justify-content-between">
        <div class="d-flex justify-content-between card-header">
            <h5 class="text-primary fw-bold mb-0">
                {{ $showCourtSubmissionForm
                    ? __('ejalas::ejalas.create_court_submission')
                    : __('ejalas::ejalas.court_submission_list') }}
            </h5>
        </div>

        <div>
            @perm('jms_judicial_management create')
                @if ($canAddCourtSubmission || $showCourtSubmissionForm)
                    <button wire:click="toggleCourtSubmissionForm"
                        class="btn {{ $showCourtSubmissionForm ? 'btn-danger' : 'btn-info' }}">
                        <i class="bx {{ $showCourtSubmissionForm ? 'bx-arrow-back' : 'bx-plus' }}"></i>
                        {{ $showCourtSubmissionForm ? __('ejalas::ejalas.back') : __('ejalas::ejalas.create_court_submission') }}
                    </button>
                @endif
            @endperm

        </div>
    </div>
    @if (!$showCourtSubmissionForm)
        <livewire:ejalas.court_submission_table theme="bootstrap-4" :complaintRegistration="$complaintRegistration" />
    @else
        <form wire:submit.prevent="save">
            <div class="card-body">
                <div class="row">
                    <div class='col-md-6 mb-3' wire:ignore>
                        <div class='form-group'>
                            <label for='complaint_registration_id'
                                class="form-label ">{{ __('ejalas::ejalas.complaint_no') }}</label>
                            <input wire:model='courtSubmission.complaint_registration_id'
                                name='complaint_registration_id' type='text' class='form-control' readonly>
                        </div>
                    </div>

                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='discussion_date'
                                class="form-label">{{ __('ejalas::ejalas.discussion_date') }}</label>
                            <input wire:model='courtSubmission.discussion_date' name='discussion_date' type='text'
                                id="discussion_date" class='form-control nepali-date'
                                placeholder="{{ __('ejalas::ejalas.enter_discussion_date') }}">
                            <div>
                                @error('courtSubmission.discussion_date')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='submission_decision_date'
                                class="form-label">{{ __('ejalas::ejalas.submission_decision_date') }}</label>
                            <input wire:model='courtSubmission.submission_decision_date' name='submission_decision_date'
                                id="submission_decision_date" type='text' class='form-control  nepali-date'
                                placeholder="{{ __('ejalas::ejalas.enter_submission_decision_date') }}">
                            <div>
                                @error('courtSubmission.submission_decision_date')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='decision_authority_id'
                                class="form-label">{{ __('ejalas::ejalas.decision_authority') }}</label>
                            <select wire:model='courtSubmission.decision_authority_id' name='decision_authority_id'
                                class="form-select">
                                <option value="" hidden>{{ __('ejalas::ejalas.select_decision_authority') }}
                                </option>
                                @foreach ($judicialMembers as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>

                            <div>
                                @error('courtSubmission.decision_authority_id')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="divider divider-primary text-start text-primary">
                        <div class="divider-text fw-bold fs-6">{{ __('ejalas::ejalas.description') }}</div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="complainer_id" class="form-label">
                            {{ __('ejalas::ejalas.complainers') }}
                        </label>
                        @forelse ($complaintRegistration->complainers as $complainer)
                            <input type="text" class="form-control mb-2" value="{{ $complainer->name }}" readonly>
                        @empty
                            <input type="text" class="form-control mb-2"
                                value="{{ __('ejalas::ejalas.no_complainer') }}" readonly>
                        @endforelse
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="defender_id" class="form-label">
                            {{ __('ejalas::ejalas.defenders') }}
                        </label>
                        @forelse ($complaintRegistration->defenders as $defender)
                            <input type="text" class="form-control mb-2" value="{{ $defender->name }}" readonly>
                        @empty
                            <input type="text" class="form-control mb-2"
                                value="{{ __('ejalas::ejalas.no_defender') }}" readonly>
                        @endforelse
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="claim request" class="form-label">
                            {{ __('ejalas::ejalas.claim_request') }}
                        </label>
                        <input type="text" class="form-control" readonly
                            value="{{ $complaintRegistration->claim_request }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="subject" class="form-label">
                            {{ __('ejalas::ejalas.subject') }}
                        </label>
                        <input type="text" class="form-control" value="{{ $complaintRegistration->subject }}"
                            readonly>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary"
                    wire:loading.attr="disabled">{{ __('ejalas::ejalas.save') }}</button>
            </div>
        </form>
    @endif
</div>
