<div>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <button type="button" class="btn btn-info" onclick="history.back()">
                    <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
                </button>
            </div>

            <div>
                @if (isset($mapApplySteps) && $mapApplySteps->isNotEmpty())
                    @php
                        $firstStep = $mapApplySteps->first();
                        $roleFilterService = new Src\Ebps\Service\ApplicationRoleFilterService();

                        // Check if user can approve this step
                        $canUserApprove = false;
                        if ($firstStep && $firstStep->mapStep) {
                            $canUserApprove = $firstStep->mapStep->canUserApprove(auth()->user());
                        }
                    @endphp

                    @if (isSuperAdmin() || ($canUserApprove && $firstStep->status != 'accepted'))
                        <button type="button" class="btn btn-info" wire:click="changeStatus({{ $firstStep->id }})">
                            {{ $selectedStatus }} <i class="bx bx-chevron-down text-muted"></i>
                            {{ __('ebps::ebps.change_status') }}
                        </button>
                    @endif
                @endif
            </div>

            <!-- Empty space on the right -->
            <div></div>
        </div>

        <!-- Letters Section -->
        @if (isset($mapApplySteps) && $mapApplySteps->isNotEmpty())
            @foreach ($mapApplySteps as $index => $step)
                @if ($step->mapApplyStepTemplates->isNotEmpty())
                    @foreach ($step->mapApplyStepTemplates as $letter)
                        @if ($letter->form_id)
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-danger" wire:click="print({{ $letter->id }})"
                              
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                                    <i class="bx bx-printer"></i> {{ __('ebps::ebps.print') }}
                                </button>
                            </div>

                            @php
                                $form = Src\Settings\Models\Form::find($letter->form_id);
                            @endphp

                            <div class="col-md-12 mt-3">
                                <div style="border-radius: 10px; text-align: center; padding: 20px;">
                                    <div id="printContent{{ $letter->id }}" class="a4-container">
                                        <style>
                                            {{ $form?->styles ?? '' }}
                                        </style>
                                        {!! $letter->template !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif
            @endforeach
        @endif

        <!-- Files Section -->
        @if (isset($files) && count($files) > 0)
            <div class="mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white"
                        style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h5 class="mb-0"><i class="bx bx-file me-2"></i>{{ __('ebps::ebps.uploaded_files') }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">{{ __('ebps::ebps.करस') }}
                                        </th>
                                        <th class="text-center">{{ __('ebps::ebps.file_name') }}</th>
                                        <th class="text-center">{{ __('ebps::ebps.फइल') }}</th>
                                        <th class="text-center">{{ __('ebps::ebps.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $index => $file)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-center">{{ $file->title }}</td>
                                            <td class="text-center">
                                                @if ($file->file)
                                                    <a href="{{ customFileAsset(config('src.Ebps.ebps.path'), $file->file, 'local', 'tempUrl') }}"
                                                        class="btn btn-sm btn-primary" target="_blank"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="bx bx-show me-1"></i> {{ __('ebps::ebps.view') }}
                                                    </a>
                                                @else
                                                    <span class="text-muted">{{ __('ebps::ebps.no_file') }}</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    // Check if user can delete files (only approvers or superadmin)
                                                    $canUserApprove = false;
                                                    if (isset($mapApplySteps) && $mapApplySteps->isNotEmpty()) {
                                                        $firstStep = $mapApplySteps->first();
                                                        if ($firstStep && $firstStep->mapStep) {
                                                            $canUserApprove = $firstStep->mapStep->canUserApprove(
                                                                auth()->user(),
                                                            );
                                                        }
                                                    }
                                                @endphp

                                                @if (isSuperAdmin() || $canUserApprove)
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        wire:click="deleteFile({{ $file->id }})"
                                                        wire:confirm="{{ __('ebps::ebps.are_you_sure_you_want_to_delete_this_file') }}">
                                                        <i class="bx bx-trash"></i> {{ __('ebps::ebps.delete') }}
                                                    </button>
                                                @else
                                                    <span class="text-muted small">No permission to delete</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        @endif


        @if ($mapApplySteps->first()?->mapStep?->position == '3' && $additionalForms)
            <div class="mt-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header text-white"
                        style="border-top-left-radius: 12px; border-top-right-radius: 12px;">
                        <h5 class="mb-0">
                            <i class="bx bx-file me-2"></i>{{ __('ebps::ebps.additional_form') }}
                        </h5>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">{{ __('ebps::ebps.करस') }}</th>
                                        <th class="text-center">{{ __('ebps::ebps.form_name') }}</th>
                                        <th class="text-center">{{ __('ebps::ebps.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-center">१</td>
                                        <td class="text-center">कन्सल्टेन्सी द्वारा भरिएको विवरण</td>
                                        <td class="text-center">
                                            <a target="_blank"
                                                href="{{ route('organization.ebps.map_apply.additionalFormPreview', ['id' => $mapApplyStep->map_apply_id]) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bx bx-show me-1"></i> {{ __('ebps::ebps.view') }}
                                            </a>
                                        </td>
                                    </tr>
                                    @foreach ($additionalForms as $index => $file)
                                        <tr>
                                            <td class="text-center">{{ replaceNumbersWithLocale($index + 2, true) }}
                                            </td>
                                            <td class="text-center">{{ $file->form->additionalForm->name }}</td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-sm btn-primary"
                                                    wire:click="viewAdditionalForm({{ $file->id }})"
                                                    class="btn btn-sm btn-primary">
                                                    <i class="bx bx-show me-1"></i> {{ __('ebps::ebps.view') }}
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif




    </div>


    <style>
        /* Ensure A4 Size */
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            padding: 7mm 20mm;
            margin: auto;
            background: white;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
        }

        /* Print Styling */
        @media print {
            body {
                background: white !important;
            }

            .btn {
                display: none;
            }

            .a4-container {
                width: 210mm;
                height: 297mm;
                box-shadow: none;
                margin: 0;
                padding: 7mm 20mm;
                page-break-after: always;
            }
        }
    </style>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-pdf-in-new-tab', (event) => {
                window.open(event.url, '_blank');
            });

        });
    </script>

    @if ($openStatusModal)
        <div class="modal fade show d-block" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px; overflow: hidden;">

                    <div class="modal-header bg-light py-3 px-4 border-bottom-0">
                        <h5 class="modal-title text-primary fw-bold">
                            <i class="bx bx-transfer-alt me-2"></i>{{ __('ebps::ebps.change_status') }}
                        </h5>
                        <button type="button" class="btn-close" wire:click="changeStatus"></button>
                    </div>

                    <div class="modal-body px-4 py-4">
                        <div class="mb-4">
                            <label for="statusSelect" class="form-label fw-semibold text-dark mb-2">
                                <i
                                    class="bx bx-toggle-right text-primary me-2"></i>{{ __('ebps::ebps.select_status') }}
                            </label>
                            <div class="position-relative">
                                <select id="statusSelect" class="form-select py-2 border-0 bg-light"
                                    style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.08);"
                                    wire:model="selectedStatus">
                                    <option value="">{{ __('ebps::ebps.change_status') }}</option>
                                    @foreach ($mapApplyStatusEnum as $status)
                                        <option value="{{ $status->value }}">{{ $status->label() }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="position-absolute top-50 end-0 translate-middle-y pe-3 pointer-events-none">
                                    <i class="bx bx-chevron-down text-muted"></i>
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label for="reason" class="form-label fw-semibold text-dark mb-2">
                                <i
                                    class="bx bx-message-square-detail text-primary me-2"></i>{{ __('ebps::ebps.reason_for_change') }}
                            </label>
                            <textarea id="reason" class="form-control border-0 bg-light"
                                style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.08); min-height: 100px;" wire:model.defer="reason"
                                placeholder="{{ __('ebps::ebps.enter_reason_for_changing_the_status') }}"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 px-4 py-3 bg-light">
                        <button type="button" class="btn btn-outline-secondary px-4" style="border-radius: 8px;"
                            wire:click="changeStatus">
                            <i class="bx bx-x me-1"></i>{{ __('ebps::ebps.cancel') }}
                        </button>
                        <button type="button" class="btn btn-primary px-4 ms-2"
                            style="border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"
                            wire:click="saveStatus">
                            <i class="bx bx-check me-1"></i>{{ __('ebps::ebps.save_changes') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>

    async function printDivById(letterId) {
        const { jsPDF } = window.jspdf;
        const element = document.getElementById(`printContent${letterId}`);

        if (!element) {
            console.error(`❌ printContent${letterId} element not found!`);
            return;
        }

        const canvas = await html2canvas(element, {
            scale: 2,
            useCORS: true
        });

        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4');

        const pdfWidth = pdf.internal.pageSize.getWidth();
        const imgProps = pdf.getImageProperties(imgData);
        const imgHeight = (imgProps.height * pdfWidth) / imgProps.width;
        let heightLeft = imgHeight;
        let position = 0;

        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
        heightLeft -= pdf.internal.pageSize.getHeight();

        while (heightLeft > 1) {
            position -= pdf.internal.pageSize.getHeight();
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
            heightLeft -= pdf.internal.pageSize.getHeight();
        }

        pdf.autoPrint();
        window.open(pdf.output('bloburl'), '_blank');
    }

    document.addEventListener('livewire:init', () => {
        Livewire.on('print-certificate-letter', (event) => {
            console.log('🖨️ Printing letter with ID:', event.id);
            printDivById(event.id);
        });
    });
</script>
