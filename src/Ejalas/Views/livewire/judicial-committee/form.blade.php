<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='committees_title'>{{ __('ejalas::ejalas.judicialcommittee') }}</label>
                    <input wire:model='judicialCommittee.committees_title' name='committees_title' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_committees_title') }}">
                    <div>
                        @error('judicialCommittee.committees_title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='short_title'>{{ __('ejalas::ejalas.judicialcommittee_surname') }}</label>
                    <input wire:model='judicialCommittee.short_title' name='short_title' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_short_title') }}">
                    <div>
                        @error('judicialCommittee.short_title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='title'>{{ __('ejalas::ejalas.title') }}</label>
                    <input wire:model='judicialCommittee.title' name='title' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_title') }}">
                    <div>
                        @error('judicialCommittee.title')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='subtitle'>{{ __('ejalas::ejalas.subtitle') }}</label>
                    <input wire:model='judicialCommittee.subtitle' name='subtitle' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_subtitle') }}">
                    <div>
                        @error('judicialCommittee.subtitle')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label"
                        for='formation_date'>{{ __('ejalas::ejalas.judicialcommittee_committeeformationdate') }}</label>
                    <input wire:model='judicialCommittee.formation_date' name='formation_date' type='text'
                        class='form-control' placeholder="{{ __('ejalas::ejalas.enter_formation_date') }}">
                    <div>
                        @error('judicialCommittee.formation_date')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='phone_no'>{{ __('ejalas::ejalas.phone_no') }}</label>
                    <input wire:model='judicialCommittee.phone_no' name='phone_no' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_phone_no') }}">
                    <div>
                        @error('judicialCommittee.phone_no')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 mb-3'>
                <div class='form-group'>
                    <label class="form-label" for='email'>{{ __('ejalas::ejalas.email') }}</label>
                    <input wire:model='judicialCommittee.email' name='email' type='text' class='form-control'
                        placeholder="{{ __('ejalas::ejalas.enter_email') }}">
                    <div>
                        @error('judicialCommittee.email')
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
        <a href="{{ route('admin.ejalas.judicial_committees.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('ejalas::ejalas.back') }}</a>
    </div>
</form>
