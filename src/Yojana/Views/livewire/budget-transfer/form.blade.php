<form wire:submit.prevent="save">
    <div class="card-body">
        <div class="row">
            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='from_plan'>{{ __('yojana::yojana.transfer_from') }}</label>
                    <select wire:model='budgetTransfer.from_plan' wire:change="loadPlan($event.target.value)" name="from_plan" class="form-control">
                        <option value="" hidden>{{ __('yojana::yojana._select_a_plan_') }}</option>
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->project_name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('budgetTransfer.from_plan')
                        <small class='text-danger'>{{ __(__($message)) }}</small>
                        @enderror
                    </div>
                </div>
            </div>

            <div class='col-md-6'>
                <div class='form-group'>
                    <label class="form-label" for='to_plan'>{{ __('yojana::yojana.transfer_to') }}</label>
                    <select wire:model='budgetTransfer.to_plan' name="to_plan" class="form-control">
                        <option value="" hidden>{{ __('yojana::yojana._select_a_plan_') }}</option>
                        @foreach ($filteredPlans as $plan)
                            <option value="{{ $plan->id }}">{{ $plan->project_name }}</option>
                        @endforeach
                    </select>
                    <div>
                        @error('budgetTransfer.to_plan')
                        <small class='text-danger'>{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class='col-md-12'>
                @if ($budgetSources)
                    <table class="table table-bordered mt-3">
                        <thead>
                        <tr>
                            <th>{{__('Budget Source')}}</th>
                            <th>{{__('Budget Title')}}</th>
                            <th>{{__('Expense Title')}}</th>
                            <th>{{__('Remaining Amount')}}</th>
                            <th>{{__('Transfer Amount')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($budgetSources as $index=>$source)
                            <tr>
                                <td>{{ $source->sourceType->title }}</td>
                                <td>{{ $source->budgetHead->title }}</td>
                                <td>{{ $source->expenseHead->title }}</td>
                                <td>
                                    <input type="number" wire:model="budgetSources.{{ $index }}.remaining_amount" class="form-control" readonly/>
                                </td>
                                <td>
                                    <input type="number" wire:model="budgetSources.{{ $index }}.transfer_amount" name="amount" wire:input.debounce.300ms="recalculateRemainingBudget" class="form-control {{ $errors->has('transfer'.$index .'amount') ? 'is-invalid' : '' }}" wire:ignore.self/>
        {{--                                    <input type="hidden" wire:model="transfer.{{ $index }}.id" />--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4" class="text-end"><strong>{{__('Total Transfer Amount')}}:</strong></td>
                            <td><input type="text" wire:model="budgetTransfer.amount" name="amount" class="form-control" readonly></td>
                        </tr>
                        </tfoot>
                    </table>
                @endif
            </div>
        </div>


    </div>
    <div class="card-footer">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
        <a class="btn btn-danger" type="button" wire:loading.attr="disabled" href="{{route('admin.budget_transfer.index')}}">{{ __('yojana::yojana.back') }}</a>
    </div>
</form>
