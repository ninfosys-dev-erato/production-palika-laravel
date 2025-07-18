<form wire:submit.prevent="save">
    @if($this->agreement?->id)
    <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead >
            <tr>
                <th rowspan="2">{{__('yojana::yojana.sn')}}</th>
                <th rowspan="2">{{__('yojana::yojana.activity')}}</th>
                <th rowspan="2">{{__('yojana::yojana.unit')}}</th>
                <th rowspan="2">{{__('yojana::yojana.quantity')}}</th>
                <th colspan="2">{{__('yojana::yojana.rate')}}</th>
                <th rowspan="2">{{__('yojana::yojana.amount')}}</th>
                <th rowspan="2">{{__('yojana::yojana.vat')}}</th>
                <th rowspan="2">{{__('yojana::yojana.vat_amount')}}</th>
                <th rowspan="2">{{__('yojana::yojana.remarks')}}</th>
            </tr>
            <tr>
                <th>{{__('yojana::yojana.estimated')}}</th>
                <th>{{__('yojana::yojana.contractor')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($agreementCostDetails as $index => $agreementCostDetail)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.activity_id"  type="text" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.activity')}}" readonly>
                    </td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.unit" type="text" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.unit')}}" readonly>
                    </td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.quantity" type="text" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.quantity')}}" readonly>
                    </td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.estimated_rate" type="text" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.estimated')}}" readonly>
                    </td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.contractor_rate" wire:keydown="calculateAmount({{ $index }})" type="number" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.contractor')}}">
                    </td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.amount" type="text" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.amount')}}" readonly>
                    </td>
                    <td class="pt-3">
                        <input wire:model="agreementCostDetails.{{ $index }}.vat"  wire:change="calculateVAT({{ $index }})" type="checkbox" class="form-check-input">
                    </td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.vat_amount" type="text" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.vat_amount')}}" readonly>
                    </td>
                    <td>
                        <input wire:model="agreementCostDetails.{{ $index }}.remarks" type="text" class="form-control form-control-sm" placeholder="{{__('yojana::yojana.condition')}}">
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="6" class="text-end fw-bold">{{__('yojana::yojana.total')}}</td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="{{ number_format($agreementCost->total_amount, 2) }}" readonly>
                </td>
                <td></td>
                <td>
                    <input type="text" class="form-control form-control-sm" value="{{ number_format($agreementCost->total_vat_amount, 2) }}" readonly>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="8" class="text-end fw-bold">{{__('yojana::yojana.total_with_vat')}}</td>
                <td colspan="2">
                    <input type="text" class="form-control form-control-sm" value="{{ number_format($agreementCost->total_with_vat, 2) }}" readonly>
                </td>
            </tr>
            </tfoot>

        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary me-2" wire:loading.attr="disabled">{{__('yojana::yojana.save')}}</button>
    </div>
    @else
        <div class="alert alert-danger" role="alert">{{__('yojana::yojana.create_agreement_first')}}</div>
    @endif
</form>
