<div class="card-01">
    <div class="row">
        <div class="col-md-12 mb-2">
            @php
                $data = is_array($applyRecommendation->data)
                    ? $applyRecommendation->data
                    : json_decode($applyRecommendation->data, true);
            @endphp

            @if ($data)
                @foreach ($data as $key => $field)
                    <p>
                        <strong>{{ $field['label'] }}:</strong>
                        @if ($field['type'] === 'file')
                            <br>
                            @php
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
                            @endphp

                            @if (is_array($field['value']))
                                @foreach ($field['value'] as $index => $fileValue)
                                    @php
                                        $extension = strtolower(pathinfo($fileValue, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, $imageExtensions);
                                        
                                       
                                            $fileUrl = customFileAsset(
                                                config('src.Recommendation.recommendation.path'),
                                                $fileValue,
                                                'local',
                                                'tempUrl'
                                            );
                                        
                                    @endphp

                                    @if ($isImage)
                                        <div class="card d-inline-block me-2 mb-2 cursor-pointer" style="width: 150px;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#filePreviewModal{{ $key }}{{ $index }}">
                                            <div class="card-body text-center p-2">
                                                <img src="{{ $fileUrl }}" alt="Image Preview"
                                                    class="img-fluid rounded mb-2" style="max-height: 80px;">
                                                <div class="text-muted small">Image File</div>
                                                <div class="text-truncate small">{{ basename($fileValue) }}</div>
                                            </div>
                                        </div>

                                        <!-- Modal -->
                                        <div class="modal fade"
                                            id="filePreviewModal{{ $key }}{{ $index }}" tabindex="-1"
                                            role="dialog" wire:ignore.self>
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ __('File Preview') }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <img src="{{ $fileUrl }}" alt="{{ __('File Preview') }}"
                                                            class="img-fluid rounded">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="card d-inline-block me-2 mb-2" style="width: 150px;">
                                            <div class="card-body text-center p-2">
                                                <div class="text-muted" style="font-size: 12px;">
                                                    {{ strtoupper($extension) }} File
                                                </div>
                                                <div class="text-truncate small">{{ basename($fileValue) }}</div>
                                                <a href="{{ $fileUrl }}" target="_blank"
                                                    class="btn btn-sm btn-primary mt-2">{{ __('Open') }}</a>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                @php
                                    $extension = strtolower(pathinfo($field['value'], PATHINFO_EXTENSION));
                                    $isImage = in_array($extension, $imageExtensions);
                                    $fileUrl = customAsset(
                                        config('src.Recommendation.recommendation.path'),
                                        $field['value'],
                                        'local',
                                    );
                                @endphp

                                @if ($isImage)
                                    <div class="card d-inline-block me-2 mb-2 cursor-pointer" style="width: 150px;"
                                        data-bs-toggle="modal" data-bs-target="#filePreviewModal{{ $key }}">
                                        <div class="card-body text-center p-2">
                                            <img src="{{ $fileUrl }}" alt="Image Preview"
                                                class="img-fluid rounded mb-2" style="max-height: 80px;">
                                            <div class="text-muted small">Image File</div>
                                            <div class="text-truncate small">{{ basename($field['value']) }}</div>
                                        </div>
                                    </div>

                                    <!-- Modal -->
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
                                                    <img src="{{ $fileUrl }}" alt="{{ __('File Preview') }}"
                                                        class="img-fluid rounded">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">{{ __('Close') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card d-inline-block me-2 mb-2" style="width: 150px;">
                                        <div class="card-body text-center p-2">
                                            <div class="text-muted" style="font-size: 12px;">
                                                {{ strtoupper($extension) }} File
                                            </div>
                                            <div class="text-truncate small">{{ basename($field['value']) }}</div>
                                            <a href="{{ $fileUrl }}" target="_blank"
                                                class="btn btn-sm btn-primary mt-2">{{ __('Open') }}</a>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @elseif ($field['type'] === 'table')
                            @if (array_key_exists('fields', $field))
                                <table border="1"
                                    style="border-collapse: collapse; width: 100%; border: 1px solid black;">
                                    <thead>
                                        <tr style="background-color: #f2f2f2;">
                                            @foreach ($field['fields'][0] as $headerKey => $headerField)
                                                <th style="border: 1px solid black; padding: 8px;">
                                                    {{ $headerField['label'] ?? ucfirst($headerKey) }}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($field['fields'] as $row)
                                            <tr>
                                                @foreach ($row as $column)
                                                    <td style="border: 1px solid black; padding: 8px;">
                                                        {{ $column['value'] ?? 'N/A' }}
                                                    </td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @else
                            {{ is_array($field['value']) ? implode(', ', $field['value']) : $field['value'] ?? __('recommendation::recommendation.no_value_provided') }}
                            <br>
                        @endif
                    </p>
                @endforeach
            @else
                <p>{{ __('recommendation::recommendation.no_data_available') }}</p>
            @endif
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
        });

        Livewire.on('showRejectModal', () => {
            $('#rejectModal').modal('show');
        });

        function printDiv() {
            const printContents = document.getElementById('printContent').innerHTML;
            const originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endpush
