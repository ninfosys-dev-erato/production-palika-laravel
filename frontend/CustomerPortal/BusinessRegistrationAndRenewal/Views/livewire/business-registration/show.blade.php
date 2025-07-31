<div class="card shadow-sm p-3 mt-3">
    <div class="row">
        <div class="col-12 mb-3">
            @if ($businessRegistration->data)
                @php($data = is_array($businessRegistration->data) ? $businessRegistration->data : json_decode($businessRegistration->data, true))
                @foreach ($data as $key => $field)
                    <p>
                        <strong>{{ $field['label'] }}:</strong>
                        @if ($field['type'] === 'file')
                            @if (is_array($field['value']))
                                @foreach ($field['value'] as $index => $fileValue)
                                    <img width="50"
                                        src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $fileValue, 'local') }}"
                                        alt="" class="rounded shadow-sm cursor-pointer" data-bs-toggle="modal"
                                        data-bs-target="#filePreviewModal{{ $key }}{{ $index }}">

                                    <div class="modal fade" id="filePreviewModal{{ $key }}{{ $index }}"
                                        tabindex="-1" role="dialog" wire:ignore.self>
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{ __('File Preview') }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $fileValue, 'local') }}"
                                                        alt="{{ __('File Preview') }}" class="img-fluid rounded">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <img width="50"
                                    src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $field['value'], 'local') }}"
                                    alt="" class="rounded shadow-sm cursor-pointer" data-bs-toggle="modal"
                                    data-bs-target="#filePreviewModal{{ $key }}">

                                <div class="modal fade" id="filePreviewModal{{ $key }}" tabindex="-1"
                                    role="dialog" wire:ignore.self>
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">{{ __('File Preview') }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <img src="{{ customAsset(config('src.BusinessRegistration.businessRegistration.registration'), $field['value'], 'local') }}"
                                                    alt="{{ __('File Preview') }}" class="img-fluid rounded">
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">{{ __('Close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @elseif ($field['type'] === 'table')
                            @if (array_key_exists('fields', $field))
                                <div class="table-responsive mt-2">
                                    <table class="table table-bordered table-sm">
                                        <thead class="table-light">
                                            <tr>
                                                @foreach ($field['fields'][0] as $headerField)
                                                    <th>{{ $headerField['label'] ?? ucfirst($headerField['key']) }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($field['fields'] as $row)
                                                <tr>
                                                    @foreach ($row as $column)
                                                        <td>{{ is_array($column['value']) ? implode(', ', $column['value']) : $column['value'] ?? 'N/A' }}
                                                        </td>
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        @else
                            {{ is_array($field['value']) ? implode(', ', $field['value']) : $field['value'] ?? __('No Value Provided') }}
                        @endif
                    </p>
                @endforeach
            @else
                <p class="text-muted">{{ __('No data available') }}</p>
            @endif
        </div>
    </div>

    {{-- Send for payment modal --}}
    <div class="modal fade" id="sendForPaymentModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Payable amount') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label">{{ __('Required Amount') }}</label>
                        <input type="text" id="amount" class="form-control" wire:model="amount">
                        @error('amount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="sendForPayment">{{ __('Send For Payment') }}</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Approve Modal -->
    <div class="modal fade" id="approveModal" tabindex="-1" role="dialog" wire:ignore.self>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Approval Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bill_no" class="form-label">{{ __('Bill Number') }}</label>
                        <input type="text" id="bill_no" class="form-control" wire:model="bill_no">
                        @error('bill_no')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-success"
                        wire:click="approve">{{ __('Save and Approve') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        Livewire.on('showApproveModal', () => {
            $('#approveModal').modal('show');
        });

        Livewire.on('showAmountModal', () => {
            $('#sendForPaymentModal').modal('show');
        })
    </script>
@endpush
