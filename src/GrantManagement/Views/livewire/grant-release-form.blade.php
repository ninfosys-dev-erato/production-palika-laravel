<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">

            @if ($action->value === 'create')
                <div class='col-md-6 mb-4'>
                    <div class="form-group" wire:ignore>
                        <label class='form-label'
                            for="grantee_type">{{ __('grantmanagement::grantmanagement.grant_program') }}</label>
                        <select wire:model="grantRelease.grant_program" id="select_grant_programs"
                            class="form-select form-control">
                            <option value="">{{ __('grantmanagement::grantmanagement.select_grantee_type') }}
                            </option>
                            @foreach ($grantProgram as $id => $program_name)
                                <option value="{{ $id }}">{{ $program_name }}</option>
                            @endforeach
                        </select>
                        @error('grantRelease.grant_program')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

            @endif
            <div class='col-md-6 mb-4'>
                <div class="form-group" wire:ignore>
                    <label class='form-label'
                        for="grantee_type">{{ __('grantmanagement::grantmanagement.grantee_type') }}</label>
                    <select wire:change="filterGrantee" wire:model="grantRelease.grantee_type" id="grantee_type"
                        class="form-select form-control">
                        <option value="" hidden>{{ __('grantmanagement::grantmanagement.select_grantee_type') }}
                        </option>
                        @foreach (\Src\GrantManagement\Enums\GranteeTypesEnum::cases() as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    @error('grantRelease.grantee_type')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>
                <div class="form-group">
                    <label class='form-label' for="grantee">
                        {{ __('grantmanagement::grantmanagement.grantee') }}
                    </label>

                    <select wire:model="grantRelease.grantee_id" name="grantee" class="form-select form-control">
                        <option value="">
                            {{ __('grantmanagement::grantmanagement.select_an_option') }}
                        </option>
                        @foreach ($grantees as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>

                    @error('grantRelease.grantee_id')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>

                <div class="form-group">
                    <label class='form-label' for="investment">{{ __("Grantee's Investment") }}</label>
                    <input wire:model="grantRelease.investment" type="number" id="investment" class="form-control"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_grantee_investment') }}">
                    @error('grantRelease.investment')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>
                <div class="form-group">
                    <label class='form-label'
                        for="is_new_or_ongoing">{{ __('grantmanagement::grantmanagement.new_or_constantly') }}</label>
                    <select wire:model="grantRelease.is_new_or_ongoing" id="is_new_or_ongoing" class="form-control">
                        <option value="">{{ __('grantmanagement::grantmanagement.select_grant_release') }}
                        </option>
                        <option value="new">{{ __('grantmanagement::grantmanagement.new') }}</option>
                        <option value="continue">{{ __('grantmanagement::grantmanagement.continue') }}</option>
                    </select>
                    @error('grantRelease.is_new_or_ongoing')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>


            <div class='col-md-6 mb-4'>

                <div class="form-group">
                    <label class='form-label' for="last_year_investment">{{ __("Last Year's Investment") }}</label>
                    <input wire:model="grantRelease.last_year_investment" type="number" id="last_year_investment"
                        class="form-control"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_last_year_investment') }}">
                    @error('grantRelease.last_year_investment')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>

                <div class="form-group">
                    <label class='form-label'
                        for="plot_no">{{ __('grantmanagement::grantmanagement.plots_no') }}</label>
                    <input wire:model="grantRelease.plot_no" type="text" id="plot_no" class="form-control"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_plot_no') }}">
                    @error('grantRelease.plot_no')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>

                <div class="form-group">
                    <label class='form-label'
                        for="location">{{ __('grantmanagement::grantmanagement.grant_location') }}</label>
                    <input wire:model="grantRelease.location" type="text" id="location" class="form-control"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_grant_location') }}">
                    @error('grantRelease.location')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>

                <div class="form-group">
                    <label class='form-label'
                        for="contact_person">{{ __('grantmanagement::grantmanagement.contact_person') }}</label>
                    <input wire:model="grantRelease.contact_person" type="text" id="contact_person"
                        class="form-control"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_contact_person') }}">
                    @error('grantRelease.contact_person')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>

                <div class="form-group">
                    <label class='form-label'
                        for="contact_no">{{ __('grantmanagement::grantmanagement.contact_no') }}</label>
                    <input wire:model="grantRelease.contact_no" type="text" id="contact_no" class="form-control"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_contact_number') }}">
                    @error('grantRelease.contact_no')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>

            <div class='col-md-6 mb-4'>

                <div class="form-group">
                    <label class='form-label'
                        for="condition">{{ __('grantmanagement::grantmanagement.condition') }}</label>
                    <textarea wire:model="grantRelease.condition" id="condition" class="form-control"
                        placeholder="{{ __('grantmanagement::grantmanagement.enter_condition') }}"></textarea>
                    @error('grantRelease.condition')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('grantmanagement::grantmanagement.save') }}</button>
        <a href="{{ route('admin.grant_release.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
    </div>
</form>

@push('scripts')
    <script>
        $(document).ready(function() {

            const selectElement = $("#grantee");

            const initializeSelect2 = () => {
                selectElement.select2();

                // Handle change event
                selectElement.on('change', function(e) {
                    @this.set("grantRelease.grantee", $(this).val());
                });
            }

            initializeSelect2();


            $('#select_grant_programs').select2().on('change', function(e) {
                @this.set('grantRelease.grant_program', $(this).val());
            });
        });
    </script>
@endpush
