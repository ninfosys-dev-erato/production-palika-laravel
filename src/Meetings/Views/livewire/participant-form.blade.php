<div>
    <form wire:submit.prevent="save">
        <div class="card-body">
            <div class="row">
                <div class="col-md-10 mb-3" wire:ignore>
                    @if ($action === App\Enums\Action::CREATE)
                        {{-- <x-form.select-input label="{{ __('Committee Member') }}" id="committee_member_id"
                            name="participant.committee_member_id" :options="$committeeMembers->pluck('name', 'id')->toArray()"
                            placeholder="{{ __('Choose Committee Member') }}" wireChange="loadCommitteeMemberInformation"
                            required /> --}}

                        <label class="form-label" for="committee_member_id">{{ __('Committee Member') }}</label>
                        <select id="committee_member_id" name="participant.committee_member_id" class="form-control"
                            wire:change="loadCommitteeMemberInformation($event.target.value)" required>
                            <option value="">{{ __('Choose Committee Member') }}</option>
                            @foreach ($committeeMembers as $committeeMember)
                                <option value="{{ $committeeMember->id }}"
                                    @if ($committeeMember->id == $participant->committee_member_id) selected @endif>
                                    {{ $committeeMember->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>

                @if ($action === App\Enums\Action::CREATE)
                    <div class="col-md-2 mb-3">
                        <button type="button" class="form-control" style="margin-top: 20px; width:30%; height: 70%"
                            wire:click="openMemberModal">
                            +
                        </button>
                    </div>
                @endif

                <div class='col-md-6'>
                    <x-form.text-input label="{{ __('Name') }}" id="name" name="participant.name" disabled />
                </div>
                <div class='col-md-6'>
                    <x-form.text-input label="{{ __('Designation') }}" id="designation" name="participant.designation"
                        disabled />
                </div>
                <div class='col-md-6'>
                    <x-form.text-input label="{{ __('Phone') }}" id="phone" name="participant.phone" disabled />
                </div>
                <div class='col-md-6'>
                    <x-form.text-input label="{{ __('Email') }}" id="email" name="participant.email" disabled />
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>
            <a href="{{ route('admin.meetings.manage', $meetingId) }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('Back') }}</a>
        </div>
    </form>

    @if ($showMemberModal)
        <div class="modal fade show" style="display: block; background-color: rgba(0,0,0,0.5);">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ __('Create Customer') }}</h5>
                        <button type="button" wire:click="closeMemberModal"
                            class="btn btn-light d-flex justify-content-center align-items-center shadow-sm"
                            style="width: 40px; height: 40px; border: none; background-color: transparent;">
                            <span style="color: red; font-size: 20px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <livewire:committees.committee_member_form :$action :isModalForm="true" />
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
