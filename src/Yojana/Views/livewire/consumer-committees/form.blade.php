<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='committee_type_id' class='form-label'>{{__('yojana::yojana.committee_type')}}</label>
                    <select wire:model="consumerCommittee.committee_type_id" name="committee_type_id"
                        id="committee_type_id" class="form-control">
                        <option value="" hidden>{{__('yojana::yojana.select_committee_type')}}</option>
                        @foreach ($Committee_type as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('consumerCommittee.committee_type_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='registration_number' class='form-label'>{{__('yojana::yojana.registration_number')}}</label>
                    <input wire:model='consumerCommittee.registration_number' name='registration_number' type='text'
                        class='form-control' placeholder="{{__('yojana::yojana.enter_registration_number')}}">
                    <div>
                        @error('consumerCommittee.registration_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='formation_date' class='form-label'>{{__('yojana::yojana.formation_date')}}</label>
                    <input wire:model='consumerCommittee.formation_date' name='formation_date' type='date'
                        class='form-control' placeholder="{{__('yojana::yojana.enter_formation_date')}}">
                    <div>
                        @error('consumerCommittee.formation_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='name' class='form-label'>{{__('yojana::yojana.name')}}</label>
                    <input wire:model='consumerCommittee.name' name='name' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_name')}}">
                    <div>
                        @error('consumerCommittee.name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='ward_id' class='form-label'>{{__('yojana::yojana.ward')}}</label>
                    <select wire:model='consumerCommittee.ward_id' name='ward_id' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_ward_id')}}">
                        <option value="" hidden>{{__('yojana::yojana.select_ward')}}</option>

                        @foreach ($wards as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach

                        <div>
                            @error('consumerCommittee.ward_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </select>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='address' class='form-label'>{{__('yojana::yojana.address')}}</label>
                    <input wire:model='consumerCommittee.address' name='address' type='text' class='form-control'
                        placeholder="{{__('yojana::yojana.enter_address')}}">
                    <div>
                        @error('consumerCommittee.address')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='creating_body' class='form-label'>{{__('yojana::yojana.creating_body')}}</label>
                    <input wire:model='consumerCommittee.creating_body' name='creating_body' type='text'
                        class='form-control' placeholder="{{__('yojana::yojana.enter_creating_body')}}">
                    <div>
                        @error('consumerCommittee.creating_body')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='number_of_attendees' class='form-label'>{{__('yojana::yojana.number_of_attendees')}}</label>
                    <input wire:model='consumerCommittee.number_of_attendees' name='number_of_attendees' type='number'
                           class='form-control'>
                    <div>
                        @error('consumerCommittee.number_of_attendees')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='bank_id' class='form-label'>{{__('yojana::yojana.bank')}}</label>
                    <select wire:model="consumerCommittee.bank_id" name="bank_id"
                            id="bank_id" class="form-control">
                        <option value="" hidden>{{__('yojana::yojana.select_bank')}}</option>
                        @foreach ($banks as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('consumerCommittee.bank_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='account_number' class='form-label'>{{__('yojana::yojana.account_number')}}</label>
                    <input wire:model='consumerCommittee.account_number' name='account_number' type='number'
                        class='form-control' placeholder="{{__('yojana::yojana.enter_account_number')}}">
                    <div>
                        @error('consumerCommittee.account_number')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-4'>
                <div class='form-group'>
                    <label for='formation_minute' class='form-label'>{{__('yojana::yojana.formation_minute')}} </label>
                    <input wire:model='formation_minute' name='formation_minute' type='file'
                        class='form-control' placeholder="{{__('yojana::yojana.enter_formation_minute')}}">
                    <div>
                        @error('formation_minute')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                    <div wire:loading wire:target="formation_minute">
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{__('yojana::yojana.uploading')}}...
                    </div>
                    @if ($formation_minute_url)
                        <div class="col-12 mb-3">
                            <p class="mb-1"><strong>{{ __('yojana::yojana.formation_minute_preview') }}:</strong></p>
                            <a href="{{ $formation_minute_url }}" target="_blank"
                               class="btn btn-outline-primary btn-sm">
                                <i class="bx bx-file"></i> {{ __('yojana::yojana.view_uploaded_file') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="s ubmit" class="btn btn-primary" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
        <a href="{{route('admin.consumer_committees.index')}}" wire:loading.attr="disabled"
            class="btn btn-danger">{{__('yojana::yojana.back')}}</a>
    </div>
</form>
