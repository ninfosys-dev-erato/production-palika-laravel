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
                        @if(count($quotations) >= 4)
                            @error("quotations.$index.name")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @else
                            @error("quotations.$index.name")
                                @if(str_contains($message, 'required'))
                                    {{-- Don't show required errors when less than 4 quotations --}}
                                @else
                                    <small class="text-danger">{{ $message }}</small>
                                @endif
                            @enderror
                        @endif
                    </td>
                    <td>
                        <input type="text" wire:model="quotations.{{ $index }}.address"
                            class="form-control form-control-sm" />
                        @if(count($quotations) >= 4)
                            @error("quotations.$index.address")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @else
                            @error("quotations.$index.address")
                                @if(str_contains($message, 'required'))
                                    {{-- Don't show required errors when less than 4 quotations --}}
                                @else
                                    <small class="text-danger">{{ $message }}</small>
                                @endif
                            @enderror
                        @endif
                    </td>
                    <td>
                        <input type="number" wire:model="quotations.{{ $index }}.amount"
                            class="form-control form-control-sm" />
                        @if(count($quotations) >= 4)
                            @error("quotations.$index.amount")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @else
                            @error("quotations.$index.amount")
                                @if(str_contains($message, 'required'))
                                    {{-- Don't show required errors when less than 4 quotations --}}
                                @else
                                    <small class="text-danger">{{ $message }}</small>
                                @endif
                            @enderror
                        @endif
                    </td>
                    <td wire:ignore>
                        <!-- <input type="text" wire:model="quotations.{{ $index }}.date"
                            class="form-control form-control-sm nepali-date" /> -->

                            <!-- <input type="text" 
                                wire:model="quotations.{{ $index }}.date" 
                                class="form-control form-control-sm nepali-date" 
                                placeholder="YYYY-MM-DD"> -->

                        <input type="text"
                            id="quotation-date-{{ $index }}"
                            wire:model="quotations.{{ $index }}.date"
                            class="form-control form-control-sm nepali-date"/>

                        @if(count($quotations) >= 4)
                            @error("quotations.$index.date")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @else
                            @error("quotations.$index.date")
                                @if(str_contains($message, 'required'))
                                    {{-- Don't show required errors when less than 4 quotations --}}
                                @else
                                    <small class="text-danger">{{ $message }}</small>
                                @endif
                            @enderror
                        @endif
                    </td>
                    <td>
                        <input type="number" wire:model="quotations.{{ $index }}.percentage" step="0.01"
                            class="form-control form-control-sm" />
                        @if(count($quotations) >= 4)
                            @error("quotations.$index.percentage")
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        @else
                            @error("quotations.$index.percentage")
                                @if(str_contains($message, 'required'))
                                    {{-- Don't show required errors when less than 4 quotations --}}
                                @else
                                    <small class="text-danger">{{ $message }}</small>
                                @endif
                            @enderror
                        @endif
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

