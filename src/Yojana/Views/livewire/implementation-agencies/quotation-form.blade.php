<div>
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>{{ __('yojana::yojana.quotation') }}</th>
                <th>{{ __('yojana::yojana.name') }}</th>
                <th>{{ __('yojana::yojana.address') }}</th>
                <th>{{ __('yojana::yojana.amount') }}</th>
                <th>{{ __('yojana::yojana.date') }}</th>
                <th>{{ __('yojana::yojana.le') }}%</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($quotations as $index => $quotation)
                <tr wire:key="{{$index}}">
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <input type="text" wire:model="quotations.{{ $index }}.name"
                            class="form-control form-control-sm" />
                        @error("quotations.$index.name")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </td>
                    <td>
                        <input type="text" wire:model="quotations.{{ $index }}.address"
                            class="form-control form-control-sm" />
                        @error("quotations.$index.address")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </td>
                    <td>
                        <input type="number" wire:model="quotations.{{ $index }}.amount"
                            class="form-control form-control-sm" />
                        @error("quotations.$index.amount")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </td>
                    <td wire:ignore>
                        <input type="text" wire:model="quotations.{{ $index }}.date"
                            class="form-control form-control-sm nepali-date" />
                        @error("quotations.$index.date")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </td>
                    <td>
                        <input type="number" wire:model="quotations.{{ $index }}.percentage" step="0.01"
                            class="form-control form-control-sm" />
                        @error("quotations.$index.percentage")
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </td>
                    <td class="text-center">
                        @if (count($quotations) > 3)
                            <button type="button" class="btn btn-sm btn-danger"
                                wire:click="removeQuotation({{ $index }})">
                                <i class="bx bx-trash"></i>
                            </button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-2">
        <button type="button" class="btn btn-sm btn-primary" wire:click="addQuotation">+
            {{ __('yojana::yojana.add_quotation') }}</button>
    </div>
</div>

