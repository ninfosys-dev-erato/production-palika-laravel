<div>
    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class='col-md-2'>
                    <div class='form-group'>
                        <label class="form-label" for='level_id'>{{ __('yojana::yojana.area') }}</label>
                        <select wire:model='area' name="level_id" class="form-control">
                            <option value="" hidden>{{ __('yojana::yojana.select_area') }}</option>
                            @foreach ($areas as $area)
                                <option value="{{ $area->id }}">{{ $area->area_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class='col-md-2'>
                    <div class='form-group'>
                        <label class="form-label" for='level_id'>{{ __('yojana::yojana.budget_head') }}</label>
                        <select wire:model='budgetHead' name="level_id" class="form-control">
                            <option value="" hidden>{{ __('yojana::yojana.select_budget_head') }}</option>
                            @foreach ($budgetHeads as $budgetHead)
                                <option value="{{ $budgetHead->id }}">{{ $budgetHead->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class='form-group'>
                        <label class="form-label" for='level_id'>{{ __('yojana::yojana.budget_head') }}</label>
                        <select wire:model='expenseHead' name="level_id" class="form-control">
                            <option value="" hidden>{{ __('yojana::yojana.select_budget_head') }}</option>
                            @foreach ($expenseHeads as $expenseHead)
                                <option value="{{ $expenseHead->id }}">{{ $expenseHead->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class='form-group'>
                        <label class="form-label" for='level_id'>{{ __('yojana::yojana.project_group') }}</label>
                        <select wire:model='projectGroup' name="level_id" class="form-control">
                            <option value="" hidden>{{ __('yojana::yojana.select_project_group') }}</option>
                            @foreach ($projectGroups as $projectGroup)
                                <option value="{{ $projectGroup->id }}">{{ $projectGroup->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class='form-group'>
                        <label class="form-label" for='level_id'>{{ __('yojana::yojana.plan_type') }}</label>
                        <select wire:model='planType' name="level_id" class="form-control">
                            <option value="" hidden>{{ __('yojana::yojana.select_plan_type') }}</option>
                            @foreach ($planTypes as $planType)
                                <option value="{{ $planType->value }}">{{ $planType->label() }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='col-md-2'>
                    <div class='form-group'>
                        <label class="form-label" for='level_id'>{{ __('yojana::yojana.implementation_level') }}</label>
                        <select wire:model='implementationLevel' name="level_id" class="form-control">
                            <option value="" hidden>{{ __('yojana::yojana.select_implementation_level') }}</option>
                            @foreach ($implementationLevels as $implementationLevel)
                                <option value="{{ $implementationLevel->id }}">{{ $implementationLevel->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{--            <div class='col-md-2'>--}}
                {{--                <div class='form-group'>--}}
                {{--                    <label class="form-label" for='level_id'>{{ __('yojana::yojana.plan_status') }}</label>--}}
                {{--                    <select wire:model='planStatus' name="level_id" class="form-control">--}}
                {{--                        <option value="" hidden>{{ __('yojana::yojana.select_plan_status') }}</option>--}}
                {{--                        --}}{{-- @foreach ($implementationLevels as $implementationLevel)--}}
                {{--                            <option value="{{ $implementationLevel->id }}">{{ $implementationLevel->title }}</option>--}}
                {{--                        @endforeach --}}
                {{--                    </select>--}}
                {{--                </div>--}}
                {{--            </div>--}}
            </div>
            <div class="mt-2 d-flex justify-content-end">
                <button class="btn btn-primary me-2" type="button" wire:click="search">{{__('yojana::yojana.search')}}</button>
                <button class="btn btn-danger" type="button" wire:click="clearField">{{__('yojana::yojana.clear')}}</button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="text-primary">{{__('yojana::yojana.closed_plans')}}</h5>
        </div>
        <div class="card-body">
            <livewire:yojana.closed_plans_table theme="bootstrap-4" :report="true" />
        </div>
    </div>

</div>
