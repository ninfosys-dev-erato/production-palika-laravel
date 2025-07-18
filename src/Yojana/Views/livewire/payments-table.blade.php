<div>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th> {{ __('yojana::yojana.plan_name') }}</th>
                <th> {{ __('yojana::yojana.installment') }}</th>
                <th> {{ __('yojana::yojana.agreement_date') }}</th>
                <th> {{ __('yojana::yojana.agreed_completion_date') }}</th>
                <th> {{ __('yojana::yojana.evaluation_amount') }}</th>
                <th> {{ __('yojana::yojana.vat_amount') }}</th>
                <th> {{ __('yojana::yojana.payment_amount') }}</th>
                @if (can('payments edit') || can('payments delete'))
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
                            $date = $row->plan->agreement_date ?? null;
                            echo $date && strtotime($date) ? replaceNumbers($date, true) : '-';
                        @endphp
                    </td>

                    <td>
                        @php
                            $date = $row->evaluation->completion_date ?? null;
                            echo $date && strtotime($date) ? replaceNumbers($date, true) : '-';
                        @endphp
                    </td>

                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($row->evaluation_amount ?? 0), true) }}</td>
                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format($row->vat_amount ?? 0), true) }}</td>
                    <td>{{ __('yojana::yojana.rs').replaceNumbersWithLocale(number_format(($row->evaluation_amount ?? 0) + ($row->vat_amount ?? 0)), true) }}</td>

                    @if (can('payments edit') || can('payments delete'))
                        <td>
                            @if (can('payments edit'))
                                <button class="btn btn-primary btn-sm" wire:click="edit({{ $row->id }})"
                                        title>
                                    <i class="bx bx-edit"></i>
                                </button>
                            @endif
                            @if (can('payments edit'))
                                <button class="btn btn-info btn-sm" wire:click="printWorkOrder({{ $row->id }})"
                                    title>
                                    <i class="bx bx-file"></i>
                                </button>
                            @endif
                                @if (can('payments delete'))
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
