<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('ejalas::ejalas.name') }}</label>
                    <input wire:model='judicialMember.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_name') }}">
                    <div>
                        @error('judicialMember.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label"
                        for='member_position'>{{ __('ejalas::ejalas.ejalashjudicialcommitteeposition') }}</label>
                    <Select wire:model='judicialMember.member_position' name='member_position' type='text'
                        class='form-control'>
                        <option value=""hidden>{{ __('ejalas::ejalas.select_a_position') }}</option>
                        @foreach ($judicalMemberPositions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </Select>
                    {{-- <input wire:model='judicialMember.member_position' name='member_position' type='text' class='form-control' placeholder="{{__('ejalas::ejalas.enter_member_position')}}"> --}}
                    <div>
                        @error('judicialMember.member_position')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='elected_position'>{{ __('ejalas::ejalas.elected_position') }}</label>
                    <select wire:model='judicialMember.elected_position' name='elected_position' type='text'
                        class='form-control'>
                        <option value=""hidden>{{ __('ejalas::ejalas.select_a_position') }}</option>
                        @foreach ($electedPositions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach

                    </select>
                    {{-- <input wire:model='judicialMember.elected_position' name='elected_position' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_elected_position') }}"> --}}
                    <div>
                        @error('judicialMember.elected_position')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6 mt-4'>
                <div class='form-group'>
                    <label class="form-label" for='status'>{{ __('ejalas::ejalas.active') }}</label>
                    <input wire:model='judicialMember.status' name='status' type='checkbox'
                        class="form-check-input border-dark p-2 mt-1"
                        placeholder="{{ __('ejalas::ejalas.enter_status') }}">
                    <div>
                        @error('judicialMember.status')
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
        <a href="{{ route('admin.ejalas.judicial_members.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
