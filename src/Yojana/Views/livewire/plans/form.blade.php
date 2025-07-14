<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row ">
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text fw-bold fs-6">{{ __('yojana::yojana.basic_details') }}</div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='project_name'>{{ __('yojana::yojana.project_name') }}</label>
                    <input wire:model='plan.project_name' name='project_name' type='text'
                        class='form-control {{ $errors->has('plan.project_name') ? 'is-invalid' : '' }}'
                        placeholder="{{ __('yojana::yojana.enter_project_name') }}">
                    <div>
                        @error('plan.project_name')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label"
                        for='implementation_method_id'>{{ __('yojana::yojana.implementation_method') }}</label>
                    <select wire:model='plan.implementation_method_id' name='implementation_method_id' type='text'
                        class='form-control {{ $errors->has('plan.implementation_method_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_implementation_method') }}</option>

                        @foreach ($implementationMethods as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.implementation_method_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='location'>{{ __('yojana::yojana.location') }}</label>
                    <input wire:model='plan.location' name='location' type='text'
                        class='form-control {{ $errors->has('plan.location') ? 'is-invalid' : '' }}'
                        placeholder="{{ __('yojana::yojana.enter_location') }}">
                    <div>
                        @error('plan.location')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='ward_id'>{{ __('yojana::yojana.ward') }}</label>
                    <select wire:model='plan.ward_id' name='ward_id' type='text'
                        class='form-control {{ $errors->has('plan.ward_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_ward') }}</option>

                        @foreach ($wards as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.ward_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label"
                        for='start_fiscal_year_id'>{{ __('yojana::yojana.start_fiscal_year') }}</label>
                    <select wire:model='plan.start_fiscal_year_id' name='start_fiscal_year_id' type='date'
                        class='form-control {{ $errors->has('plan.start_fiscal_year_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_fiscal_year') }}</option>

                        @foreach ($fiscalYears as $id => $year)
                            <option value="{{ $id }}">{{ $year }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.start_fiscal_year_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label"
                        for='operate_fiscal_year_id'>{{ __('yojana::yojana.operate_fiscal_year') }}</label>
                    <select wire:model='plan.operate_fiscal_year_id' name='operate_fiscal_year_id' type='date'
                        class='form-control {{ $errors->has('plan.operate_fiscal_year_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_fiscal_year') }}</option>

                        @foreach ($fiscalYears as $id => $year)
                            <option value="{{ $id }}">{{ $year }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.operate_fiscal_year_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='area_id'>{{ __('yojana::yojana.area') }}</label>
                    <select wire:model='plan.area_id' name='area_id' type='text'
                        wire:change="updateSubRegions($event.target.value)"
                        class='form-control {{ $errors->has('plan.area_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_area') }}</option>

                        @foreach ($planAreas as $id => $area_name)
                            <option value="{{ $id }}">{{ $area_name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.area_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='sub_region_id'>{{ __('yojana::yojana.sub_region') }}</label>
                    <select wire:model='plan.sub_region_id' name='sub_region_id' type='text'
                        class='form-control {{ $errors->has('plan.sub_region_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_sub_region') }}</option>

                        @foreach ($filteredSubRegions as $region)
                            <option value="{{ $region->id }}">{{ $region->name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.sub_region_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='targeted_id'>{{ __('yojana::yojana.target') }}</label>
                    <select wire:model='plan.targeted_id' name='targeted_id' type='text'
                        class='form-control {{ $errors->has('plan.targeted_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_target') }}</option>

                        @foreach ($targets as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.targeted_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label"
                        for='implementation_level_id'>{{ __('yojana::yojana.implementation_level') }}</label>
                    <select wire:model='plan.implementation_level_id' name='implementation_level_id' type='text' wire:change="loadDepartments"
                        class='form-control {{ $errors->has('plan.implementation_level_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_implementation_level') }}</option>

                        @foreach ($implementationLevels as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.implementation_level_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            @if($isDepartment)
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label"
                           for='department'>{{ __('yojana::yojana.departments') }}</label>
                    <select wire:model='plan.department' name='department' type='text'
                            class='form-control {{ $errors->has('plan.department') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_department') }}</option>

                        @foreach ($departments as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.implementation_level_id')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            @endif

            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='plan_type'>{{ __('yojana::yojana.plan_type') }}</label>
                    <select wire:model='plan.plan_type' name='plan_type' type='text'
                        class='form-control {{ $errors->has('plan.plan_type') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_plan_type') }}</option>

                        @foreach ($planTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.plan_type')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='nature'>{{ __('yojana::yojana.nature') }}</label>
                    <select wire:model='plan.nature' name='nature' type='text'
                        class='form-control {{ $errors->has('plan.nature') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_nature') }}</option>

                        @foreach ($natures as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.nature')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='project_group_id'>{{ __('yojana::yojana.project_group') }}</label>
                    <select wire:model='plan.project_group_id' name='project_group_id' type='text'
                        class='form-control {{ $errors->has('plan.project_group_id') ? 'is-invalid' : '' }}'>
                        <option value="" hidden>{{ __('yojana::yojana.select_project_group') }}</option>

                        @foreach ($projectGroups as $id => $title)
                            <option value="{{ $id }}">{{ $title }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('plan.project_group_id')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label" for='purpose'>{{ __('yojana::yojana.purpose') }}</label>
                    <input wire:model='plan.purpose' name='purpose' type='text'
                        class='form-control {{ $errors->has('plan.purpose') ? 'is-invalid' : '' }}'
                        placeholder="{{ __('yojana::yojana.enter_purpose') }}">
                    <div>
                        @error('plan.purpose')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-6 p-2'>
                <div class='form-group'>
                    <label class="form-label"
                        for='red_book_detail'>{{ __('yojana::yojana.red_book_detail') }}</label>
                    <input wire:model='plan.red_book_detail' name='red_book_detail' type='text'
                        class='form-control {{ $errors->has('plan.red_book_detail') ? 'is-invalid' : '' }}'
                        placeholder="{{ __('yojana::yojana.enter_red_book_detail') }}">
                    <div>
                        @error('plan.red_book_detail')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text fw-bold fs-6">{{ __('yojana::yojana.budget_description') }}</div>
            </div>
            <div class='col-md-4 p-2'>
                <div class='form-group'>
                    <label class="form-label text-primary"
                        for='allocated_budget'>{{ __('yojana::yojana.allocated_budget') }}</label>
                    <input wire:model='plan.allocated_budget' name='allocated_budget' type='number'
                        class='form-control {{ $errors->has('plan.allocated_budget') ? 'is-invalid' : '' }}'
                        placeholder="{{ __('yojana::yojana.enter_allocated_budget') }}">
                    <div>
                        @error('plan.allocated_budget')
                            <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            <div class='col-md-4 text-center'>
                <h6 class="text-primary">{{ __('yojana::yojana.amount_transferred') }}</h6>
                <h5 class="text-left">
                    {{ replaceNumbersWithLocale($plan->allocated_budget - $plan->remaining_budget ?? 0, true) }}</h5>
            </div>
            <div class='col-md-4 text-center'>
                <h6 class="text-primary">{{ __('yojana::yojana.final_budget') }}</h6>
                <h5>{{ replaceNumbersWithLocale($plan->remaining_budget ?? 0, true) }}</h5>
            </div>
            <div class="divider divider-primary text-start text-primary font-14">
                <div class="divider-text fw-bold fs-6">{{ __('yojana::yojana.budget_source_details') }}</div>
            </div>


            @foreach ($budgetSources as $index => $budgetSource)
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-10">
                                <div class="row">
                                    <div class='col-md-6 p-2'>
                                        <div class='form-group'>
                                            <label class="form-label"
                                                for='source_id'>{{ __('yojana::yojana.source') }}</label>
                                            <select wire:model='budgetSources.{{ $index }}.source_id'
                                                name='budgetSources.{{ $index }}source_id' type='text'
                                                class='form-control {{ $errors->has('plan.source_id') ? 'is-invalid' : '' }}'>
                                                <option value="" hidden>{{ __('yojana::yojana.select_source') }}
                                                </option>

                                                @foreach ($sources as $id => $title)
                                                    <option value="{{ $id }}">{{ $title }}</option>
                                                @endforeach
                                            </select>
                                            <div>
                                                @error('plan.source_id')
                                                    <small class='text-danger'>{{ __($message) }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 p-2'>
                                        <div class='form-group'>
                                            <label class="form-label"
                                                for='program'>{{ __('yojana::yojana.program') }}</label>
                                            <select wire:model='budgetSources.{{ $index }}.program'
                                                name='budgetSources.{{ $index }}program' type='text'
                                                class='form-control {{ $errors->has('plan.program') ? 'is-invalid' : '' }}'>
                                                <option value="" hidden>
                                                    {{ __('yojana::yojana.select_program') }}</option>

                                                @foreach ($programs as $program)
                                                    <option value="{{ $program->id }}">{{ $program->program.' [ '.__('yojana::yojana.budget_rs'). replaceNumbersWithLocale($program->remaining_amount,true) .' ] '}}</option>
                                                @endforeach
                                            </select>
                                            <div>
                                                @error('plan.program')
                                                    <small class='text-danger'>{{ __($message) }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 p-2'>
                                        <div class='form-group'>
                                            <label class="form-label"
                                                for='budget_head_id'>{{ __('yojana::yojana.budget_head') }}</label>
                                            <select wire:model='budgetSources.{{ $index }}.budget_head_id'
                                                name='budgetSources.{{ $index }}.budget_head_id'
                                                type='text'
                                                class='form-control {{ $errors->has('plan.budget_head_id') ? 'is-invalid' : '' }}'>
                                                <option value="" hidden>
                                                    {{ __('yojana::yojana.select_budget_head') }}</option>

                                                @foreach ($budgetHeads as $id => $title)
                                                    <option value="{{ $id }}">{{ $title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div>
                                                @error('plan.budget_head_id')
                                                    <small class='text-danger'>{{ __($message) }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 p-2'>
                                        <div class='form-group'>
                                            <label class="form-label"
                                                for='expense_head_id'>{{ __('yojana::yojana.expense_head') }}</label>
                                            <select wire:model='budgetSources.{{ $index }}.expense_head_id'
                                                name='budgetSources.{{ $index }}.expense_head_id'
                                                type='text'
                                                class='form-control {{ $errors->has('plan.expense_head_id') ? 'is-invalid' : '' }}'>
                                                <option value="" hidden>
                                                    {{ __('yojana::yojana.select_expense_head') }}</option>

                                                @foreach ($expenseHeads as $expenseHead)
                                                    <option value="{{ $expenseHead->id }}">{{ $expenseHead->title . ' ' . replaceNumbersWithLocale($expenseHead->code, true)}}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div>
                                                @error('plan.expense_head_id')
                                                    <small class='text-danger'>{{ __($message) }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 p-2'>
                                        <div class='form-group'>
                                            <label class="form-label"
                                                for='fiscal_year_id'>{{ __('yojana::yojana.fiscal_year') }}</label>
                                            <select wire:model='budgetSources.{{ $index }}.fiscal_year_id'
                                                name='budgetSources.{{ $index }}.fiscal_year_id'
                                                type='date'
                                                class='form-control {{ $errors->has('plan.fiscal_year_id') ? 'is-invalid' : '' }}'>
                                                <option value="" hidden>
                                                    {{ __('yojana::yojana.select_fiscal_year') }}</option>

                                                @foreach ($fiscalYears as $id => $year)
                                                    <option value="{{ $id }}">{{ $year }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div>
                                                @error('plan.fiscal_year_id')
                                                    <small class='text-danger'>{{ __($message) }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class='col-md-6 p-2'>
                                        <div class='form-group'>
                                            <label class="form-label"
                                                for='amount'>{{ __('yojana::yojana.amount') }}</label>
                                            <input wire:model='budgetSources.{{ $index }}.amount'
                                                wire:keydown="recalculateAllocatedBudget"
                                                name='budgetSources.{{ $index }}.amount' type='number'
                                                class='form-control {{ $errors->has('plan.amount') ? 'is-invalid' : '' }}'
                                                placeholder="{{ __('yojana::yojana.enter_amount') }}">
                                            <div>
                                                @error('plan.amount')
                                                    <small class='text-danger'>{{ __($message) }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 d-flex justify-content-end align-items-center mb-3">
                                <button type="button" class="btn btn-danger btn-sm"
                                    wire:click="removeBudgetSource({{ $index }})">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach



            <div class=" d-flex justify-content-between mb-4">
                <button type="button" class="btn btn-info" wire:click='addBudgetSource'>
                    + {{ __('yojana::yojana.add_budget_source') }}
                </button>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary"
            wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <a href="{{ route('admin.plans.index') }}" wire:loading.attr="disabled"
            class="btn btn-danger">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>
