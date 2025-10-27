<div>
    <div class="container py-4">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="d-flex justify-content-between align-items-center mx-4 mb-0">
                <div class="divider divider-primary text-start text-primary fw-bold flex-grow-1 mb-0">
                    <div class="divider-text fs-5">
                        {{ __('ejalas::ejalas.complaint_registration_report') }}
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
                    <!-- Start Date -->
                    <div class="col-md col-12">
                        <label for="startDate" class="form-label">{{ __('ejalas::ejalas.ejalashstartdate') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-time"></i></span>
                            <input type="text" class="form-control border-start-0 nepali-date " id="startDate"
                                wire:model="startDate" placeholder="{{ __('ejalas::ejalas.ejalashstartdate') }}">
                        </div>
                        @error('startDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- End Date -->
                    <div class="col-md col-12">
                        <label for="endDate" class="form-label">{{ __('ejalas::ejalas.ejalashenddate') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-time"></i></span>
                            <input type="text" class="form-control border-start-0 nepali-date" id="endDate"
                                wire:model="endDate" placeholder="{{ __('ejalas::ejalas.ejalashenddate') }}">
                        </div>
                        @error('endDate')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.fiscal_year') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedFiscalYear">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($fiscalYears as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedFiscalYear')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.status') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedStatus">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($allStatus as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedStatus')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                </div>

                <div class="row g-3 align-items-center mt-3">
                    <!-- Dispute Matter -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.dispute_matter') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedDisputeMatter">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($disputeMatters as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedDisputeMatter')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                    <!-- Dispute Area -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.dispute_area') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedDisputeArea">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($disputeAreas as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedDisputeArea')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>
                    <!-- Ward -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.ward') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedWard">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($wards as $value)
                                    <option value="{{ $value }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedWard')
                            <small class="text-danger">{{ __($message) }}</small>
                        @enderror
                    </div>

                    <!-- Reg address -->
                    <div class="col-md col-12">
                        <label class="form-label">{{ __('ejalas::ejalas.place_of_registration') }}</label>
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white border-0"><i
                                    class="bx bx-layer"></i></span>
                            <select class="form-select" wire:model="selectedRegAddress">
                                <option value="">{{ __('ejalas::ejalas.select_an_option') }}</option>
                                @foreach ($regAddresses as $id => $value)
                                    <option value="{{ $id }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('selectedRegAddress')
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

        @if ($complaints && $complaints->count())
            <div class=" mt-4" id="printReportContent">
                <div>
                    {!! $letterHead !!}
                    <div class="d-flex justify-content-end">
                        <p>मिति: {{ $nepaliDate }}</p>
                    </div>
                    <table class="bordered-table">
                        <thead>
                            <tr>
                                <th>दर्ता नं.</th>
                                <th>दर्ता मिति</th>
                                <th>दर्ता भएको ठाउँ</th>
                                <th>निवेदक</th>
                                <th>विपक्षी</th>
                                <th>वार्ड</th>
                                <th>विवादको क्षेत्र</th>
                                <th>विवादको विषय</th>
                                <th>विवादको अवस्था</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $complaint)
                                <tr class="hover:bg-gray-50">
                                    <td>{{ $complaint->reg_no }}</td>
                                    <td>{{ $complaint->reg_date }}</td>
                                    <td>{{ $complaint->reg_address?->label() }}</td>
                                    <td>{{ $complaint->complainers->pluck('name')->implode(', ') }}</td>
                                    <td>{{ $complaint->defenders->pluck('name')->implode(', ') }}</td>
                                    <td>{{ $complaint->ward_no }}</td>
                                    <td>{{ $complaint->disputeMatter?->disputeArea?->title ?? '' }}</td>
                                    <td>{{ $complaint->disputeMatter?->title ?? '' }}</td>
                                    <td>{{ $complaint->status?->label() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="container mt-4">
                <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                    style="min-height: 200px;">
                    <h5 class="text-center">{{ __('ejalas::ejalas.no_data_to_show') }}</h5>

                    @error('startDate')
                        <small class="text-danger">{{ __($message) }}</small>
                    @enderror

                    @error('endDate')
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
