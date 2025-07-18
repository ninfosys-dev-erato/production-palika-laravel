<div>
    <form wire:submit.prevent="save">
        <div class="card-body">
            <div class="row">

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label class='form-label'
                            for='fiscal_year'>{{ __('grantmanagement::grantmanagement.fiscal_year') }}</label>
                        <select wire:model='grantProgram.fiscal_year_id' name='fiscal_year' class='form-control'>
                            <option value="">{{ __('grantmanagement::grantmanagement.select_fiscal_year') }}
                            </option>
                            @foreach ($fiscalYears as $id => $year)
                                <option value="{{ $id }}">
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('grantProgram.fiscal_year_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label class='form-label'
                            for='type_of_grant'>{{ __('grantmanagement::grantmanagement.grant_type') }}</label>
                        <select wire:model='grantProgram.type_of_grant_id' name='type_of_grant' class='form-control'>
                            <option value="">{{ __('grantmanagement::grantmanagement.select_grant_type') }}
                            </option>
                            @foreach ($GrantTypes as $id => $title)
                                <option value="{{ $id }}">
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('grantProgram.type_of_grant_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='program_name'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.program_name') }}</label>
                        <input wire:model='grantProgram.program_name' name='program_name' type='text'
                            class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_program_name') }}">
                        <div>
                            @error('grantProgram.program_name')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='granting_organization'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.grant_office') }}</label>
                        <select wire:model='grantProgram.granting_organization_id' name='granting_organization'
                            class='form-control'>
                            <option value="">{{ __('grantmanagement::grantmanagement.select_grant_office') }}
                            </option>
                            @foreach ($GrantingOrganizations as $id => $office_name)
                                <option value="{{ $id }}">
                                    {{ $office_name }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('grantProgram.granting_organization_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='branch'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.branch') }}</label>
                        <select wire:model='grantProgram.branch_id' name='branch' class='form-control'>
                            <option value="">{{ __('grantmanagement::grantmanagement.select_branch') }}</option>
                            @foreach ($branches as $id => $title)
                                <option value="{{ $id }}">
                                    {{ $title }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('grantProgram.branch_id')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='grant_provided_type'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.grant_delivered_type') }}</label>
                        <select wire:model="grantProgram.grant_provided_type" wire:change="ToggleSection"
                            name='grant_provided_type' class='form-control'>
                            <option value="">
                                {{ __('grantmanagement::grantmanagement.enter_grant_delivered_type') }}
                            </option>
                            @foreach (\Src\GrantManagement\Enums\GrantEnum::cases() as $type)
                                <option value="{{ $type->value }}">
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                        <div>
                            @error('grantProgram.grant_provided_type')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>



                <!-- Conditional form sections based on grantGiven -->
                @if ($toggleGrantSection == 'cash')
                    <div class='col-md-6 mb-4'>
                        <div class='form-group'>
                            <label for='grant_amount'
                                class='form-label'>{{ __('grantmanagement::grantmanagement.grant_amount') }}</label>
                            <input wire:model='grantProgram.grant_amount' name='grant_amount' type='text'
                                class='form-control'
                                placeholder="{{ __('grantmanagement::grantmanagement.enter_grant_amount') }}">
                            <div>
                                @error('grantProgram.grant_amount')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                @elseif($toggleGrantSection == 'gensi')
                    <div class="row">
                        <div class='col-md-6 mb-4'>
                            <div class='form-group'>
                                <label for='grant_items'
                                    class='form-label'>{{ __('grantmanagement::grantmanagement.grant_items') }}</label>
                                <input wire:model='grantProgram.grant_provided' name='grant_items' type='text'
                                    class='form-control'
                                    placeholder="{{ __('grantmanagement::grantmanagement.enter_grant_items') }}">
                                <div>
                                    @error('grantProgram.grant_provided')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class='col-md-6 mb-4'>
                            <div class='form-group'>
                                <label for='grant_quantity'
                                    class='form-label'>{{ __('grantmanagement::grantmanagement.grant_quantity') }}</label>
                                <input wire:model='grantProgram.grant_provided_quantity' name='grant_quantity'
                                    type='text' class='form-control'
                                    placeholder="{{ __('grantmanagement::grantmanagement.enter_grant_quantity') }}">
                                <div>
                                    @error('grantProgram.grant_provided_quantity')
                                        <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class='col-md-6 mb-4'>
                    <div class='form-group' wire:ignore>
                        <label for='for_grant'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.for_grant') }}</label>
                        <select name='selectedGrants' id="selectedGrants"
                            class='form-control select2-component' multiple wire:ignore>
                            @foreach ($forGrants as $grant)
                                <option value="{{ $grant['value'] }}">{{ $grant['label'] }}</option>
                            @endforeach
                        </select>

                        <div>
                            @error('grantProgram.for_grant')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class='col-md-6 mb-4'>
                    <div class='form-group'>
                        <label for='condition'
                            class='form-label'>{{ __('grantmanagement::grantmanagement.condition') }}</label>
                        <textarea wire:model='grantProgram.condition' name='condition' type='text' class='form-control'
                            placeholder="{{ __('grantmanagement::grantmanagement.enter_condition') }}" rows="5"></textarea>
                        <div>
                            @error('grantProgram.condition')
                                <small class='text-danger'>{{ __($message) }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"
                wire:loading.attr="disabled">{{ __('grantmanagement::grantmanagement.save') }}</button>
            <a href="{{ route('admin.grant_programs.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('grantmanagement::grantmanagement.back') }}</a>
        </div>
    </form>
</div>

@push('scripts')
    <script>
        // document.addEventListener('livewire:load', function() {
        //     const select = $('#for-grant-select');

        //     // Initialize Select2
        //     select.select2();

        //     // Set initial value from Livewire
        //     Livewire.on('loadSelect2ForGrant', (values) => {
        //         select.val(values).trigger('change');
        //     });

        //     // Handle change event to update Livewire property
        //     select.on('change', function() {
        //         @this.set('HoldTempForGrant', $(this).val());
        //     });
        // });


         $(document).ready(function() {
            const elements = [{
                    id: '#selectedGrants',
                    placeholder: "{{ __('grantmanagement::grantmanagement.select_farmers') }}",
                    selectedValues: @json($grantProgram->for_grant) ?? [],
                    updateFunction: 'updateSelectedForGrant'
                },
            ];

            elements.forEach(function(element) {
                const selectElement = $(element.id);

                selectElement.select2({
                    placeholder: element.placeholder,
                    allowClear: true,
                    width: '100%'
                });

                // Set selected values
                selectElement.val(element.selectedValues).trigger('change');

                // Handle change event
                selectElement.on('change', function() {
                    @this.call(element.updateFunction, $(this).val());
                });

            });

           
        });



       
    </script>
@endpush
