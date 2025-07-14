<form wire:submit.prevent="save">
    <!-- Step Indicator -->
    <div class="wizard-header mb-4">
        <h5>Step {{ $step }} of {{ $maxPages }}</h5>
    </div>

    <!-- Dynamic Form Content -->
    @switch($step)
        @case(1)
            <div>
                <div class="card-head">
                    {{ __('Meeting Detail') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Fiscal Year Selection -->
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="fiscal_year_id" class="form-label">{{ __('Fiscal Year') }}</label>

                                <select wire:model="initialMeeting.fiscal_year_id" name="initialMeeting.fiscal_year_id"
                                    class="form-select" id="fiscal_year_id">
                                    <option value="">{{ __('Select an option') }}</option>
                                    @foreach ($fiscalYears as $id => $value)
                                        <option value="{{ $id }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('initialMeeting.fiscal_year_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>


                        <!-- Committee Selection -->
                        <div class="col-md-6" wire:ignore>
                            <x-form.select-input label="{{ __('Committee') }}" id="committee_id"
                                name="initialMeeting.committee_id" :options="\Src\Committees\Models\Committee::get()
                                    ->pluck('committee_name', 'id')
                                    ->toArray()" placeholder="{{ __('Choose Committee') }}"
                                required />
                        </div>

                        <!-- Meeting Name -->
                        <div class="col-md-12 mt-3">
                            <x-form.text-input label="{{ __('Meeting') }}" id="meeting_name"
                                name="initialMeeting.meeting_name" />
                        </div>

                        <!-- Start Date -->
                        <div class="col-md-6">
                            <label for="start_date">{{ __('Start Date & Time') }}</label>
                            <div class="d-flex gap-2">
                                <!-- Date Input -->
                                <input type="text" name="initialMeeting.start_date" id="start_date"
                                    class="form-control {{ $errors->has('initialMeeting.start_date') ? 'is-invalid' : '' }} nepali-date"
                                    style="{{ $errors->has('initialMeeting.start_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:model="initialMeeting.start_date" placeholder="{{ __('Select Date') }}" />

                                <!-- Time Input -->
                                <input type="time" class="form-control" wire:model="start_time">
                            </div>

                            @error('initialMeeting.start_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- End Date & Time -->
                        <div class="col-md-6">
                            <label for="end_date">{{ __('End Date & Time') }}</label>
                            <div class="d-flex gap-2">
                                <!-- Date Input -->
                                <input type="text" name="initialMeeting.end_date" id="end_date"
                                    class="form-control {{ $errors->has('initialMeeting.end_date') ? 'is-invalid' : '' }} nepali-date"
                                    style="{{ $errors->has('initialMeeting.end_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                    wire:model="initialMeeting.end_date" placeholder="{{ __('Select Date') }}" />

                                <!-- Time Input -->
                                <input type="time" class="form-control" wire:model="end_time">
                            </div>

                            @error('initialMeeting.end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Recurrence Type -->
                        <div class="col-md-12 mt-3">
                            <label for="recurrence">{{ __('Recurrence Type') }}</label>
                            <select id="recurrence" name="initialMeeting.recurrence" class="form-control"
                                class="form-control {{ $errors->has('initialMeeting.recurrence') ? 'is-invalid' : '' }}"
                                style="{{ $errors->has('initialMeeting.recurrence') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                wire:model="initialMeeting.recurrence">
                                <option value="">{{ __('Choose Recurrence Type') }}</option>
                                @foreach (\Src\Meetings\Enums\RecurrenceTypeEnum::getValuesWithLabels() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('initialMeeting.recurrence')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Recurrence End Date -->
                        <div class="col-md-6 mt-3">
                            <label for="recurrence_end_date">{{ __('Recurrence End Date') }}</label>
                            <input type="text" name="initialMeeting.recurrence_end_date" id="recurrence_end_date"
                                wire:model="initialMeeting.recurrence_end_date"
                                class="form-control {{ $errors->has('initialMeeting.recurrence_end_date') ? 'is-invalid' : '' }} nepali-date"
                                style="{{ $errors->has('initialMeeting.recurrence_end_date') ? 'border: 1px solid #dc3545; box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);' : '' }}"
                                placeholder="{{ __('Select Date') }}" />

                            @error('initialMeeting.recurrence_end_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <h6 class="mb-1 my-3">{{ __('Copy:') }}</h6>
                        <div class='col-md-12 d-flex gap-2'>
                            <button class="btn btn-secondary btn-sm" data-bs-copiable="meeting_title" type="button">
                                {{ __('Meeting Title') }}
                            </button>
                            <button class="btn btn-secondary btn-sm" data-bs-copiable="state_date" type="button">Meeting
                                {{ __('Start Date') }}
                            </button>
                            <button class="btn btn-secondary btn-sm" data-bs-copiable="end_date" type="button">Meeting
                                {{ __('End Date') }}
                            </button>
                            <button class="btn btn-secondary btn-sm" data-bs-copiable="committee_name" type="button">
                                {{ __('Committee Name') }}
                            </button>
                        </div>
                        <!-- Message -->
                        <div class="col-md-12">
                            <x-form.textarea-input label="{{ __('Message') }}" id="description"
                                name="initialMeeting.description" />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Meeting Details Step -->
        @break

        @case(2)
            <!-- Agendas Step -->
            <div class="card-head">
                {{ __('Agendas') }}
            </div>
            <div class="card-body">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('S.No.') }}</th>
                            <th>{{ __('Proposal') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Is Final') }}</th>
                            <th>
                                <button type="button" wire:click.prevent="addAgenda" class="btn btn-sm btn-primary"><i
                                        class="bx bx-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas ?? [] as $index => $agenda)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <x-form.text-input label="" id="proposal"
                                        name="agendas.{{ $index }}.proposal" />
                                </td>
                                <td>
                                    <x-form.textarea-input label="" id="description"
                                        name="agendas.{{ $index }}.description" />
                                </td>
                                <td>
                                    <x-form.select-input label="" id="is_final"
                                        name="agendas.{{ $index }}.is_final" :options="[0 => 'No', 1 => 'Yes']"
                                        placeholder="Choose the option" />
                                </td>
                                <td>
                                    <button type="button" wire:click.prevent="removeAgenda({{ $index }})"
                                        class="btn btn-sm btn-danger"><i class="bx bx-minus"></i></button>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        @break

        @case(3)
            <!-- Invite Members Step -->
            <div class="card-head">
                <livewire:phone_search />
                {{ __('Invite Members') }}
            </div>
            <div class="card-body">
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('S.No.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Designation') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>
                                <button type="button" wire:click.prevent="addInvitedMember" class="btn btn-sm btn-primary">
                                    <i class="bx bx-plus"></i></button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invitedMembers ?? [] as $key => $invitedMembers)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <x-form.text-input label="" id="name"
                                        name="invitedMembers.{{ $key }}.name" />
                                </td>
                                <td>
                                    <x-form.text-input label="" id="designation"
                                        name="invitedMembers.{{ $key }}.designation" />
                                </td>
                                <td>
                                    <x-form.text-input label="" id="phone"
                                        name="invitedMembers.{{ $key }}.phone" />
                                </td>
                                <td>
                                    <x-form.text-input label="" id="email"
                                        name="invitedMembers.{{ $key }}.email" />
                                </td>
                                <td>
                                    <button type="button" wire:click.prevent="removeInvitedMember({{ $key }})"
                                        class="btn btn-sm btn-danger"><i class="bx bx-minus"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @break

        @case(4)
            <!-- Meeting Preview Step -->
            <div class="card-head">
                {{ __('Meeting Preview') }}
            </div>
            <div class="card-body">
                @php
                    $fiscalYear = \Src\Settings\Models\FiscalYear::find((int) ($initialMeeting['fiscal_year_id'] ?? 0));
                @endphp
                <p><strong>{{ __('Fiscal Year') }}:</strong>
                    {{ $fiscalYear?->year ?? '' }}
                </p>
                {{-- <p><strong>{{ __('Fiscal Year') }}:</strong>
                    {{ array_key_exists('fiscal_year_id', $initialMeeting) ? \Src\Settings\Models\FiscalYear::find($initialMeeting['fiscal_year_id'])?->year : '' }}
                    {{ $initialMeeting }}
                </p> --}}
                <p><strong>{{ __('Committee') }}:</strong>{{ array_key_exists('committee_id', $initialMeeting) ? \Src\Committees\Models\Committee::find($initialMeeting['committee_id'])->committee_name : '' }}
                </p>
                <p><strong>{{ __('Meeting') }}:</strong> {{ $initialMeeting['meeting_name'] ?? '' }}</p>
                <p><strong>{{ __('Recurrence') }}:</strong>
                    {{ array_key_exists('recurrence', $initialMeeting) ? \Src\Meetings\Enums\RecurrenceTypeEnum::tryFrom($initialMeeting['recurrence'])?->label() : '' }}
                </p>
                <p><strong>{{ __('Start Date') }}:</strong> {{ $initialMeeting['start_date'] ?? '' }}</p>
                <p><strong>{{ __('End Date') }}:</strong> {{ $initialMeeting['end_date'] ?? '' }}</p>
                <p><strong>{{ __('Recurrence End Date') }}:</strong> {{ $initialMeeting['recurrence_end_date'] ?? '' }}</p>
                <p><strong>{{ __('Description') }}:</strong> {{ $initialMeeting['description'] ?? '' }}</p>

                <p><strong>{{ __('Agendas') }}</strong></p>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('S.No.') }}</th>
                            <th>{{ __('Proposal') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Is Final') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas ?? [] as $agenda)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $agenda['proposal'] }}
                                </td>
                                <td>
                                    {{ $agenda['description'] }}
                                </td>
                                <td>
                                    {{ $agenda['is_final'] ? 'Yes' : 'No' }}
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <p><strong>{{ __('Invited Members') }}</strong></p>
                <table class="table table-striped table-responsive">
                    <thead>
                        <tr>
                            <th>{{ __('S.No.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Designation') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Email') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invitedMembers ?? [] as $invitedMembers)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $invitedMembers['name'] }}
                                </td>
                                <td>
                                    {{ $invitedMembers['designation'] }}
                                </td>
                                <td>
                                    {{ $invitedMembers['phone'] }}
                                </td>
                                <td>
                                    {{ $invitedMembers['email'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @break

    @endswitch

    <!-- Navigation Buttons -->
    <div class="card-footer d-flex justify-content-between mt-3">
        @if ($step > 1)
            <button type="button" wire:click.prevent="previousPage" class="btn btn-secondary"
                wire:loading.attr="disabled">{{ __('Previous') }}
            </button>
        @endif
        @if ($step < $maxPages)
            <button type="button" wire:click.prevent="nextPage" class="btn btn-primary"
                wire:loading.attr="disabled">
                {{ __('Next Page') }}
            </button>
        @else
            <button type="submit" class="btn btn-success"
                wire:loading.attr="disabled">{{ __('Save') }}</button>
        @endif
    </div>

    <!-- Copiable Script -->
    @once
        @push('scripts')
            <script src="{{ asset('assets/js/copiable.js') }}"></script>
        @endpush
    @endonce
</form>