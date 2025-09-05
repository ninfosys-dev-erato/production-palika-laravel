<form wire:submit.prevent="save">
    @if(is_null($evaluation) && $category == 'plan')
        <div class="p-3">
            <strong>{{__('yojana::yojana.select_an_evaluation_to_make_payment')}}</strong>
        </div>
    @else
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <h5 class="text-primary">{{ __('yojana::yojana.plan_details') }}</h5>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='agreement_date' class='form-label'>{{ __('yojana::yojana.agreement_date') }}</label>
                            <input wire:model='payment.agreement_date' name='payment.agreement_date' type='text' class='form-control'
                                   readonly>
                            <div>
                                @error('payment.agreement_date')
                                <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='agreed_completion_date' class='form-label'>{{ __('yojana::yojana.project_completion_date') }}</label>
                            <input wire:model='payment.agreed_completion_date' name='payment.agreed_completion_date' type='text'
                                   class='form-control'  readonly>
                            <div>
                                @error('payment.agreed_completion_date')
                                <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @if($category == 'plan')
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='evaluation_date' class='form-label'>{{ __('yojana::yojana.evaluation_date') }}</label>
                            <input wire:model='payment.evaluation_date' name='evaluation_date' type='text'
                                   class='form-control' id="evaluation_date">
                            <div>
                                @error('payment.evaluation_date')
                                <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='completion_date' class='form-label'>{{ __('yojana::yojana.payment_date') }}</label>
                            <input wire:model='payment.payment_date' id="payment_date" name='payment_date'
                                   type='date' class='form-control {{ $errors->has('payment.payment_date') ? 'is-invalid' : '' }}'>
                            <div>
                                @error('payment.payment_date')
                                <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-primary">{{__('yojana::yojana.implementation_details')}}</h5>
                <div class="row">
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='implementationMethod'
                                   class='form-label'>{{ __('yojana::yojana.implementation_method') }}</label>
                            <input wire:model='payment.implementation_method' name='implementationMethod' type='text'
                                   class='form-control' readonly>
                            <div>
                                @error('payment.implementationMethod')
                                <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='implementation_agency' class='form-label'>{{ __('yojana::yojana.implementation_agency') }}</label>
                            <input wire:model='payment.implementation_agency' name='implementation_agency' type='text' class='form-control'
                                   readonly>
                            <div>
                                @error('payment.implementation_agency')
                                <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6 mb-3'>
                        <div class='form-group'>
                            <label for='implementation_agency_address' class='form-label'>{{ __("yojana::yojana.implementation_agency_address") }}</label>
                            <input wire:model='payment.implementation_agency_address' name='implementation_agency_address' type='text' class='form-control'
                                   readonly>
                            <div>
                                @error('payment.implementation_agency_address')
                                <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                @if($category == 'plan')
                <h5 class="text-primary">{{__('yojana::yojana.evaluation_details')}}</h5>
                @elseif($category == 'program')
                    <h5 class="text-primary">{{__('yojana::yojana.bill_details')}}</h5>
                @endif

                    <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{__('yojana::yojana.estimated_cost')}}</th>
                            <th>{{__('yojana::yojana.agreement_amount')}}</th>
                            <th>{{__('yojana::yojana.total_paid_amount')}}</th>
                            <th>{{__('yojana::yojana.payable_amount')}}</th>
                            @if($category == 'plan')
                                <th>{{__('yojana::yojana.installment')}}</th>
                                <th>{{__('yojana::yojana.a_evaluation_amount')}}</th>
                                <th>{{__('yojana::yojana.without_tax')}}</th>
                            @endif
                            @if($category == 'program')
                                <th>{{__('yojana::yojana.bill_amount')}}</th>

                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($payment['estimated_cost'] ?? 0), true) }}</td>
                            <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($payment['agreement_cost'] ?? 0), true) }}</td>
                            <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($payment['total_paid_amount'] ?? 0), true) }}</td>
                            <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($payment['total_payable_amount'] ?? 0), true) }}</td>
                            @if($category == 'plan')
                                <td>{{ $payment['installment'] ?? '-' }}</td>
                                <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($payment['evaluation_amount'] ?? 0), true) }}</td>
                                <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($payment['evaluation_amount_without_tax'] ?? 0), true) }}</td>
                            @endif
                            @if($category == 'program')
                                <td><input  wire:model='payment.bill_amount' wire:input="calculateTotalAmount" type='number' value="0" class='form-control {{ $errors->has('payment.bill_amount') ? 'is-invalid' : '' }}'>
                                    @error('payment.bill_amount')
                                        <small class='text-danger'>{{ $message }}</small>
                                    @enderror
                                </td>
                            @endif
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @if($category == 'plan')
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-primary">{{__('yojana::yojana.budget_source_details')}}</h5>
                <div>
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>{{__('yojana::yojana.sn')}}</th>
                            <th>{{__('yojana::yojana.budget_sources')}}</th>
                            <th>{{__('yojana::yojana.budget_subtitle')}}</th>
                            <th>{{__('yojana::yojana.expense_title')}}</th>
                            <th>{{__('yojana::yojana.program')}}</th>
                            <th>{{__('yojana::yojana.year')}}</th>
                            <th>{{__('yojana::yojana.balance')}}</th>
                            <th>{{__('yojana::yojana.amount')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($budgetSources as $index=>$budgetSource)
                            <tr>
                                <td> {{$index + 1}}</td>
                                <td>{{$budgetSource?->sourceType?->title ?? '-'}}</td>
                                <td>{{$budgetSource?->budgetHead?->title ?? '-'}}</td>
                                <td>{{$budgetSource?->expenseHead?->title ?? '-'}}</td>
                                <td>{{$budgetSource?->budgetDetail?->program ?? '-'}}</td>
                                <td>{{$budgetSource?->fiscalYear?->year ?? '-'}}</td>
                                <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($calculatedRemaining[$index] ?? $budgetSource?->remaining_amount ?? 0), true)}}</td>
                                <td><input   wire:model="budgetSourceDetails.{{$index}}.amount"  wire:input="calculateRemainingBudget({{ $index }})" name='amount' type='number' value="0" class='form-control {{ $errors->has('budgetSourceDetails.'.$index.'.amount') ? 'is-invalid' : '' }}'>
                                    @error('budgetSourceDetails.'.$index.'.amount')
                                    <small class='text-danger'>{{ $message }}</small>
                                    @enderror

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif


        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-primary">{{__('yojana::yojana.advance_payment_details')}}</h5>
                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{__('yojana::yojana.total_advance_paid')}}</th>
                            <th>{{__('yojana::yojana.advance_clear_before')}}</th>
                            <th>{{__('yojana::yojana.advance_clear_current')}}</th>
                            <th>{{__('yojana::yojana.advance_due')}}</th>
                            <th>{{__('yojana::yojana.b_advance_deduction')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="number" class="form-control" wire:model="payment.total_paid_amount" readonly></td>
                            <td><input type="number" class="form-control" wire:model="payment.previous_advance" readonly></td>
                            <td><input type="number" class="form-control {{ $errors->has('payment.current_advance') ? 'is-invalid' : '' }}" wire:model="payment.current_advance" wire:input="calculateAdvanceDue" min="0" value="0">
                                @error('payment.current_advance')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </td>
                            <td><input type="number" class="form-control" wire:model="payment.advance_due"  readonly></td>
                            <td><input type="number" class="form-control" wire:model="payment.advance_deduction" readonly></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @if($category =='plan')
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-primary">{{__('yojana::yojana.deposit_details')}}</h5>
                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{__('yojana::yojana.total_deposit')}}</th>
                            <th>{{__('yojana::yojana.deposit_before')}}</th>
                            <th>{{__('yojana::yojana.deposit_current')}}</th>
                            <th>{{__('yojana::yojana.c_deposit_deduction')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" class="form-control" wire:model="payment.total_deposit"  readonly></td>
                            <td><input type="text" class="form-control" wire:model="payment.previous_deposit"  readonly></td>
                            <td><input type="text" class="form-control {{ $errors->has('payment.current_deposit') ? 'is-invalid' : '' }}" wire:model="payment.current_deposit" wire:input="calculateDeposit">
                                @error('payment.current_deposit')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </td>
                            <td><input type="text" class="form-control" wire:model="payment.deposit_deduction" readonly></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

        <div class="card mt-3">
            <div class="card-body">
                <h5 class="text-primary">{{__('yojana::yojana.tax_deduction_details')}}</h5>
                <div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>{{__('yojana::yojana.tax_head')}}</th>
                            <th>{{__('yojana::yojana.evaluation_amount')}}</th>
                            <th>{{__('yojana::yojana.tax_rate')}}</th>
                            <th>{{__('yojana::yojana.amount')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                <select wire:model="tax.name" wire:change="updateRate($event.target.value)"
                                        class='form-control {{ $errors->has('tax.name') ? 'is-invalid' : '' }}'>
                                    <option value="" hidden>{{__('yojana::yojana.select')}}</option>
                                    @foreach($taxHeads as $head)
                                        <option value="{{ $head->id }}">{{ $head->title }}</option>
                                    @endforeach
                                </select>
                                <div>
                                    @error('tax.name')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </td>
                            <td>
                                <input type="number" wire:model="tax.evaluation_amount" wire:input="calculateTax"
                                       class='form-control {{ $errors->has('tax.evaluation_amount') ? 'is-invalid' : '' }}'>
                                <div>
                                    @error('tax.evaluation_amount')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </td>


                            <td>
                                <input type="number" wire:model="tax.rate"
                                       class='form-control {{ $errors->has('tax.rate') ? 'is-invalid' : '' }}'>
                                <div>
                                    @error('tax.rate')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </td>


                            <td>
                                <input type="number" wire:model="tax.amount" readonly
                                       class='form-control {{ $errors->has('tax.amount') ? 'is-invalid' : '' }}'>
                                <div>
                                    @error('tax.amount')
                                    <small class='text-danger'>{{ __($message) }}</small>
                                    @enderror
                                </div>
                            </td>

                        </tr>
                        <tr>
                            <td colspan="4" class="text-end">
                                <button class="btn btn-danger" type="button" wire:click="addTax">{{__('yojana::yojana.add')}}</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('yojana::yojana.tax_head')}}</th>
                            <th>{{__('yojana::yojana.evaluation_amount')}}</th>
                            <th>{{__('yojana::yojana.tax_rate')}}</th>
                            <th>{{__('yojana::yojana.amount')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($taxRecords as $index => $tax)
                            <tr>
                                <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                                <td>{{ $tax['title'] }}</td>
                                <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($tax['evaluation_amount'] ?? 0), true) }}</td>
                                <td>{{ replaceNumbersWithLocale($tax['rate'] ?? '-', true) . ' %' }}</td>
                                <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($tax['amount'] ?? 0), true) }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                            wire:click="removeTaxRecord('{{ $index }}')">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        @if(empty($taxRecords))
                            <td colspan="6" class="text-center">{{ __('yojana::yojana.no_records_added') }}</td>

                        @endif
                        </tbody>
                    </table>

                    <!-- Final Calculation Summary -->
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>{{__('yojana::yojana.d_total_tax_deduction')}}</th>
                            <td><input type="text" class="form-control {{ $errors->has('payment.total_tax_deduction') ? 'is-invalid' : '' }}" wire:model="payment.total_tax_deduction">
                                @error('payment.total_tax_deduction')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>{{__('yojana::yojana.e_total_deduction__bcd')}}</th>
                            <td><input type="text" class="form-control {{ $errors->has('payment.total_deduction') ? 'is-invalid' : '' }}" wire:model="payment.total_deduction" >
                                @error('payment.total_deduction')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </td>
                        </tr>
                        <tr>
                            <th>{{__('yojana::yojana.f_paid_amount__ae')}}</th>
                            <td><input type="text" class="form-control {{ $errors->has('payment.paid_amount') ? 'is-invalid' : '' }}" wire:model="payment.paid_amount" >
                                @error('payment.paid_amount')
                                    <small class='text-danger'>{{ $message }}</small>
                                @enderror
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('yojana::yojana.save') }}</button>
            {{-- <a href="{{ route('admin.evaluations.index') }}" wire:loading.attr="disabled"
                class="btn btn-danger">{{ __('yojana::yojana.back') }}</a> --}}
        </div>
    @endif
</form>

