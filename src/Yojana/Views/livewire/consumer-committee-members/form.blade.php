<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='citizenship_number'
                        class='form-label'>{{ __('yojana::yojana.citizenship_number') }}</label>
                    <input wire:model='consumerCommitteeMember.citizenship_number' name='citizenship_number' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_citizenship_number') }}">
                    <div>
                        @error('consumerCommitteeMember.citizenship_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='name' class='form-label'>{{ __('yojana::yojana.name') }}</label>
                    <input wire:model='consumerCommitteeMember.name' name='name' type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_name') }}">
                    <div>
                        @error('consumerCommitteeMember.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='gender' class='form-label'>{{ __('yojana::yojana.gender') }}</label>
                    {{-- <input wire:model='consumerCommitteeMember.gender' name='gender' type='text' class='form-control'
                           placeholder="{{__('yojana::yojana.enter_gender')}}"> --}}
                    <select name="" id="" class="form-select"
                        wire:model='consumerCommitteeMember.gender'>
                        <option value=""hidden>{{ __('yojana::yojana.select_an_option') }}</option>
                        <option value="Male">{{ __('yojana::yojana.male') }}</option>
                        <option value="Female">{{ __('yojana::yojana.female') }}</option>
                    </select>
                    <div>
                        @error('consumerCommitteeMember.gender')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='father_name' class='form-label'>{{ __('yojana::yojana.father_name') }}</label>
                    <input wire:model='consumerCommitteeMember.father_name' name='father_name' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_father_name') }}">
                    <div>
                        @error('consumerCommitteeMember.father_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='husband_name' class='form-label'>{{ __('yojana::yojana.husband_name') }}</label>
                    <input wire:model='consumerCommitteeMember.husband_name' name='husband_name' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_husband_name') }}">
                    <div>
                        @error('consumerCommitteeMember.husband_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='grandfather_name'
                        class='form-label'>{{ __('yojana::yojana.grandfather_name') }}</label>
                    <input wire:model='consumerCommitteeMember.grandfather_name' name='grandfather_name' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_grandfather_name') }}">
                    <div>
                        @error('consumerCommitteeMember.grandfather_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='father_in_law_name'
                        class='form-label'>{{ __('yojana::yojana.father_in_law_name') }}</label>
                    <input wire:model='consumerCommitteeMember.father_in_law_name' name='father_in_law_name'
                        type='text' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_father_in_law_name') }}">
                    <div>
                        @error('consumerCommitteeMember.father_in_law_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='designation' class='form-label'>{{ __('yojana::yojana.designation') }}</label>
                    {{-- <input wire:model='consumerCommitteeMember.designation' name='designation' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_designation') }}"> --}}
                    <select name="" class="form-select" wire:model='consumerCommitteeMember.designation'>
                        <option value=""hidden>{{ __('yojana::yojana.select_an_option') }}</option>
                        @foreach ($designations as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('consumerCommitteeMember.designation')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='address' class='form-label'>{{ __('yojana::yojana.address') }}</label>
                    <input wire:model='consumerCommitteeMember.address' name='address' type='text'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_address') }}">
                    <div>
                        @error('consumerCommitteeMember.address')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='mobile_number' class='form-label'>{{ __('yojana::yojana.mobile_number') }}</label>
                    <input wire:model='consumerCommitteeMember.mobile_number' name='mobile_number' type='number'
                        class='form-control' placeholder="{{ __('yojana::yojana.enter_mobile_number') }}">
                    <div>
                        @error('consumerCommitteeMember.mobile_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='citizenship_upload'
                        class='form-label'>{{ __('yojana::yojana.citizenship_upload') }}</label>
                    <input wire:model='citizenship' name='citizenship_upload' type='file' class='form-control'
                        placeholder="{{ __('yojana::yojana.enter_citizenship_upload') }}">
                    <div wire:loading wire:target="citizenship">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        Uploading...
                    </div>
                    @if ($citizenshipUrl)
                        <div class="col-12 mb-3">
                            <p class="mb-1">
                                <strong>{{ __('yojana::yojana.citizenship_preview') }}:</strong>
                            </p>
                            <a href="{{ $citizenshipUrl }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                    <div>
                        @error('consumerCommitteeMember.citizenship_upload')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>

                    <label for='is_account_holder'
                        class='form-label'>{{ __('yojana::yojana.is_account_holder') }}</label>

                    <input wire:model='consumerCommitteeMember.is_account_holder' name='is_account_holder'
                        type='checkbox' class='form-check-input ms-3 mt-1 p-2'
                        placeholder="{{ __('yojana::yojana.enter_is_account_holder') }}">
                    <div>
                        @error('consumerCommitteeMember.is_account_holder')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label for='is_monitoring_committee'
                        class='form-label'>{{ __('yojana::yojana.is_monitoring_committee') }}</label>
                    <input wire:model='consumerCommitteeMember.is_monitoring_committee' name='is_monitoring_committee'
                        type='checkbox' class='form-check-input ms-3 mt-1 p-2'>
                    <div>
                        @error('consumerCommitteeMember.is_monitoring_committee')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <a href="{{ route('admin.consumer_committee_members.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>
