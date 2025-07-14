<form wire:submit.prevent="save">
    <div class="card shadow-lg p-4 rounded-lg">
        <div class="row">
            <!-- Title -->
            <div class="col-md-12 mb-4">
                <div class="form-group">
                    <label class="form-label font-semibold text-lg" for='title'>{{ __('ebps::ebps.title') }}</label>
                    <input wire:model='mapStep.title' name='title' type='text'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'
                        placeholder="{{ __('ebps::ebps.enter_title') }}">
                    <div class="mt-2">
                        @error('mapStep.title')
                            <small class='text-red-500 text-sm'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label font-semibold text-lg"
                        for='application_type'>{{ __('ebps::ebps.application_type') }}</label>
                    <select wire:model='mapStep.application_type' name='application_type' class='form-control'>
                        <option value="">{{ __('ebps::ebps.select_application_type') }}</option>
                        @foreach ($applicationTypes as $type)
                            <option value="{{ $type->value }}">{{ $type->label() }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('mapStep.application_type')
                            <small class='text-danger'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Position -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="form-label font-semibold text-lg"
                        for='form_position'>{{ __('ebps::ebps.form_position') }}</label>
                    <select wire:model='mapStep.form_position' name='form_position'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'>
                        <option value="" hidden>{{ __('ebps::ebps.select_form_position') }}</option>
                        @foreach (\Src\Ebps\Enums\FormPositionEnum::cases() as $position)
                            <option value="{{ $position->value }}">{{ $position->label() }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        @error('mapStep.form_position')
                            <small class='text-red-500 text-sm'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Form Submitter -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="form-label font-semibold text-lg"
                        for='form_submitter'>{{ __('ebps::ebps.form_submitter') }}</label>
                    <select wire:model='mapStep.form_submitter' name='form_submitter'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'
                        wire:change="checkFormSubmitter">
                        <option value="">{{ __('ebps::ebps.select_form_submitter') }}</option>
                        @foreach (\Src\Ebps\Enums\FormSubmitterEnum::cases() as $submitter)
                            <option value="{{ $submitter->value }}">{{ $submitter->label() }}</option>
                        @endforeach
                    </select>
                    <div class="mt-2">
                        @error('mapStep.form_submitter')
                            <small class='text-red-500 text-sm'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Step For -->
            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="form-label font-semibold text-lg" for='step_for'>{{ __('ebps::ebps.step_for') }}</label>
                    <input wire:model='mapStep.step_for' name='step_for' type='text'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'
                        placeholder="{{ __('ebps::ebps.enter_step_for') }}">
                    <div class="mt-2">
                        @error('mapStep.step_for')
                            <small class='text-red-500 text-sm'>{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Conditional Fields for Consultant -->
            @if (!$isConsultant)
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label class="form-label font-semibold text-lg" for='submitter'>{{ __('ebps::ebps.submitter') }}</label>
                        <select wire:model.defer='submitter' name='submitter'
                            class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'>
                            <option value="">{{ __('ebps::ebps.select_submitter') }}</option>
                            @foreach ($mapPassGroup as $groupUser)
                                <option value="{{ $groupUser['id'] }}">{{ $groupUser['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label class="form-label font-semibold text-lg"
                            for='submitter_position'>{{ __('ebps::ebps.position') }}</label>
                        <input wire:model='submitter_position' name='submitter_position' type='number'
                            class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'
                            placeholder="{{ __('ebps::ebps.enter_position') }}">
                    </div>
                </div>
            @endif

            <!-- Submitter and Reviewer for Non-Consultant -->

            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="form-label font-semibold text-lg" for='reviewer'>{{ __('ebps::ebps.reviewer') }}</label>

                    <select wire:model='reviewer' name='reviewer'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'>
                        <option value="">{{ __('ebps::ebps.select_reviewer') }}</option>
                        @foreach ($mapPassGroup as $groupUser)
                            <option value="{{ $groupUser['id'] }}">{{ $groupUser['title'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="form-group">
                    <label class="form-label font-semibold text-lg"
                        for='reviewer_position'>{{ __('ebps::ebps.position') }}</label>
                    <input wire:model='reviewer_position' name='reviewer_position' type='number'
                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'
                        placeholder="{{ __('ebps::ebps.enter_position') }}">
                </div>
            </div>


            <!-- Add Approver -->
            <div class="d-flex justify-content-between my-4">
                <label class="form-label font-semibold text-lg" for="add_approver">{{ __('ebps::ebps.add_approver') }} +</label>
                <button type="button" class="btn btn-info" wire:click='addApprover'>
                    <i class="bx bx-plus"></i> {{ __('ebps::ebps.add_approver') }}
                </button>
            </div>

            @foreach ($approverSelects as $index => $selected)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Approver Selection -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label font-semibold text-lg"
                                        for="approver-{{ $index }}">{{ __('ebps::ebps.approver') }}</label>
                                    <select wire:model="approverSelects.{{ $index }}"
                                        name="approverSelects[{{ $index }}]"
                                        id="approver-{{ $index }}"
                                        class="form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400">
                                        <option value="">{{ __('ebps::ebps.select_approver') }}</option>
                                        @foreach ($mapPassGroup as $user)
                                            <option value="{{ $user['id'] }}">{{ $user['title'] }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error("approverSelects.$index")
                                            <small class="text-red-500 text-sm">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Approver Position -->
                            <div class="col-md-5 mb-3">
                                <div class="form-group" wire:ignore>
                                    <label for="approver_position_{{ $index }}"
                                        class="form-label font-semibold text-lg">{{ __('ebps::ebps.position') }}</label>
                                    <input wire:model='approverPosition.{{ $index }}'
                                        name='approverPosition{{ $index }}' type='number'
                                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'
                                        placeholder="{{ __('ebps::ebps.enter_position') }}">
                                </div>
                                @error("approverPosition.$index")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remove Approver Button -->
                            <div class="col-md-1 d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeApprover({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between my-4">
                <label class="form-label font-semibold text-lg" for="add_approver">{{ __('ebps::ebps.add_form') }} +</label>
                <button type="button" class="btn btn-info" wire:click='addForm'>
                    <i class="bx bx-plus"></i>{{ __('ebps::ebps.add_form') }}
                </button>
            </div>

            @foreach ($formSelects as $index => $selected)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Approver Selection -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label font-semibold text-lg"
                                        for="form-{{ $index }}">{{ __('ebps::ebps.form') }}</label>
                                    <select wire:model="formSelects.{{ $index }}"
                                        name="formSelects[{{ $index }}]" id="form-{{ $index }}"
                                        class="form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400">
                                        <option value="">{{ __('ebps::ebps.select_form') }}</option>
                                        @foreach ($forms as $form)
                                            <option value="{{ $form['id'] }}">{{ $form['title'] }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error("formSelects.$index")
                                            <small class="text-red-500 text-sm">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!-- Remove Approver Button -->
                            <div class="col-md-1 d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeForm({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="d-flex justify-content-between my-4">
                <label class="form-label font-semibold text-lg" for="add_approver">{{ __('ebps::ebps.add_construction_type') }}
                    +</label>
                <button type="button" class="btn btn-info" wire:click='addConstructionType'>
                    <i class="bx bx-plus"></i> {{ __('ebps::ebps.add_construction_type') }}
                </button>
            </div>

            @foreach ($constructionTypeSelects as $index => $selected)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <!-- Approver Selection -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label class="form-label font-semibold text-lg"
                                        for="construction_type-{{ $index }}">{{ __('ebps::ebps.construction_type') }}</label>
                                    <select wire:model="constructionTypeSelects.{{ $index }}"
                                        name="constructionTypeSelects[{{ $index }}]"
                                        id="construction_type-{{ $index }}"
                                        class="form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400">
                                        <option value="">{{ __('ebps::ebps.select_construction_type') }}</option>
                                        @foreach ($constructionTypes as $type)
                                            <option value="{{ $type['id'] }}">{{ $type['title'] }}</option>
                                        @endforeach
                                    </select>
                                    <div>
                                        @error("constructionTypeSelects.$index")
                                            <small class="text-red-500 text-sm">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5 mb-3">
                                <div class="form-group" wire:ignore>
                                    <label for="construction_type_position_{{ $index }}"
                                        class="form-label font-semibold text-lg">{{ __('ebps::ebps.position') }}</label>
                                    <input wire:model='constructionTypePosition.{{ $index }}'
                                        name='constructionTypePosition{{ $index }}' type='number'
                                        class='form-control p-2 border-2 rounded-md focus:ring-2 focus:ring-indigo-400'
                                        placeholder="{{ __('ebps::ebps.enter_position') }}">
                                </div>
                                @error("constructionTypePosition.$index")
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remove Approver Button -->
                            <div class="col-md-1 d-flex align-items-center justify-content-end">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeConstructionType({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class='col-md-6 mb-4'>
                <div class="form-group">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="can_skip" wire:model="canSkip"
                            @if ($canSkip) checked @endif>
                        <label class="form-check-label text-lg" for="can_skip">{{ __('ebps::ebps.can_skip') }}</label>
                    </div>
                </div>
            </div>

            <div class='col-md-6 mb-4'>
                <div class="form-group">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" id="is_public" wire:model="isPublic"
                            @if ($isPublic) checked @endif>
                        <label class="form-check-label text-lg" for="is_public">{{ __('ebps::ebps.is_public') }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('ebps::ebps.save') }}</button>
            <a href="{{ route('admin.ebps.map_steps.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('ebps::ebps.back') }}</a>
        </div>
    </div>
</form>
