<div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> {{ __('yojana::yojana.plan_name') }}</th>
                <th> {{ __('yojana::yojana.installment') }}</th>
                <th> {{ __('yojana::yojana.agreement_date') }}</th>
                <th> {{ __('yojana::yojana.payment_date') }}</th>
                <th> {{ __('yojana::yojana.evaluation_amount') }}</th>
                <th> {{ __('yojana::yojana.total_deduction') }}</th>
                <th> {{ __('yojana::yojana.payment_amount') }}</th>
                @if (can('plan edit') || can('plan delete'))
                    <th>{{__('yojana::yojana.actions')}}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($payments as $row)
                <tr>
                    <td>{{ $row->plan->project_name ?? '-' }}</td>
                    <td>{{ $row->installment?->label() ?? '-' }}</td>

                    <td>
                        @php
                            $date = $row->plan->agreement->created_at ?? null;
                            echo $date && strtotime($date) ? replaceNumbers(ne_date($date), true) : '-';
                        @endphp
                    </td>

                    <td>
                        @php
                            $date = $row->payment_date ?? null;
                            echo $date && strtotime($date) ? replaceNumbers($date, true) : '-';
                        @endphp
                    </td>

                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($row->evaluation_amount ?? 0), true) }}</td>
                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($row->total_deduction ?? 0), true) }}</td>
                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format(($row->paid_amount ?? 0) + ($row->vat_amount ?? 0)), true) }}</td>

                    @if (can('plan edit') || can('plan delete'))
                        <td>
                            @if (can('plan edit'))
                                <button class="btn btn-primary btn-sm" wire:click="edit({{ $row->id }})"
                                        title>
                                    <i class="bx bx-edit"></i>
                                </button>
                            @endif
                            @if (can('plan edit'))
                                <button class="btn btn-info btn-sm" wire:click="printWorkOrder({{ $row->id }})"
                                    title>
                                    <i class="bx bx-file"></i>
                                </button>
                            @endif
                                @if (can('plan delete'))
                                <button class="btn btn-danger btn-sm" wire:click="delete({{ $row->id }})"
                                    title>
                                    <i class="bx bx-trash"></i>
                                </button>
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
