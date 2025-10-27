<div>

    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="d-flex justify-content-between align-items-center mx-4 mb-0">
                <div class="divider divider-primary text-start text-primary fw-bold flex-grow-1 mb-0">
                    <div class="divider-text fs-5">
                        {{ __('ejalas::ejalas.fiscal_year_report') }}
                    </div>
                </div>
                <div class="d-flex gap-2 ms-3 mt-3">
                    {{-- <button type="button" wire:click="export" class="btn btn-outline-primary btn-sm">
                        {{ __('Export') }}
                    </button> --}}
                    <button wire:click="downloadPdf" class="btn btn-outline-primary btn-sm">
                        {{ __('Pdf') }}
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <!-- Fiscal Year -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.fiscal_year') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedYear">
                                <option value="">{{ __('ejalas::ejalas.select_a_year') }}</option>
                                @foreach ($fiscalYears as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedYear')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Buttons -->
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center gap-2">
                        <button type="submit" class="btn btn-primary btn-sm" wire:click="searchReport"
                            wire:loading.attr="disabled" wire:target="searchReport">
                            <span wire:loading wire:target="searchReport"><i
                                    class="bx bx-loader bx-spin me-1"></i></span>
                            <span wire:loading.remove wire:target="searchReport"><i class="bx bx-search me-1"></i>
                                {{ __('ejalas::ejalas.search') }}</span>
                        </button>

                        <button type="button" class="btn btn-danger btn-sm" wire:click="clear">
                            <i class="bx bx-x-circle me-1"></i> {{ __('Clear') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="overflow-x-auto mx-auto">
        @if ($reportCollections && $reportCollections->count())
            <div class=" mt-4" id="printReportContent">
                <div>
                    {!! $letterHead !!}
                    <div class="d-flex justify-content-end">
                        <p>मिति: {{ $nepaliDate }}</p>
                    </div>
                    <table class="bordered-table">
                        <thead>
                            <tr>
                                <th>{{ __('ejalas::ejalas.dispute_matter') }}</th>
                                <th>{{ __('ejalas::ejalas.total_complaints') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalCount = 0;
                            @endphp

                            @foreach ($reportCollections as $item)
                                @php
                                    $totalCount += $item->total;
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td>{{ $item->disputeMatter->title ?? 'N/A' }}</td>
                                    <td>{{ replaceNumbers($item->total, true) }}</td>
                                </tr>
                            @endforeach

                            <!-- Total Row -->
                            <tr class="fw-bold bg-light">
                                <td>{{ __('ejalas::ejalas.total') }}</td>
                                <td>{{ replaceNumbers($totalCount, true) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="container mt-4">
                <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                    style="min-height: 200px;">
                    <h5 class="text-center">{{ __('ejalas::ejalas.no_data_to_show') }}</h5>

                    @error('selectedYear')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror
                </div>
            </div>
        @endif
    </div>
    <style>
        /* Ensure A4 Size */
        #printReportContent {
            padding: 7mm 20mm;
            background: white;
            text-align: left;
            position: relative;
            color: #333;
            font-size: 16px;
        }

        .bordered-table {
            width: 100%;
            border-collapse: collapse;
        }

        .bordered-table th,
        .bordered-table td {
            border: 1px solid black;
            padding: 8px 8px;
            text-align: left;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('print-report', () => {
                printDiv();
            });
        });
        async function printDiv() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById('printReportContent');

            const canvas = await html2canvas(element, {
                scale: 2,
                useCORS: true
            });

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            const imgProps = pdf.getImageProperties(imgData);
            const imgHeight = (imgProps.height * pdfWidth) / imgProps.width;

            let heightLeft = imgHeight;
            let position = 0;

            // Add first page
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
            heightLeft -= pdfHeight;

            // Add more pages only if needed
            while (heightLeft > 1) {
                position -= pdfHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
                heightLeft -= pdfHeight;
            }

            // Trigger browser print dialog
            pdf.autoPrint();
            window.open(pdf.output('bloburl'), '_blank');
        }
    </script>
</div>
