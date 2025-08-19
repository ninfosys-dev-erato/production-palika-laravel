<div>
    <div class="row">

        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('businessregistration::businessregistration.registration_application') }}
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button type="button" class="btn mx-2 mb-2 btn-primary" id="v-pills-basic-tab"
                            data-bs-toggle="pill" data-bs-target="#v-pills-basic" role="tab"
                            wire:click="setActiveTab('application-letter')" aria-controls="v-pills-application-letter"
                            aria-selected="false">
                            {{ __('businessregistration::businessregistration.application_letter') }}
                        </button>
                        <button type="button" class="btn mx-2 mb-2 btn-primary"data-bs-toggle="pill"
                            data-bs-target="#v-pills-documents" role="tab" aria-controls="v-pills-documents"
                            wire:click="setActiveTab('documents')" aria-selected="false">
                            {{ __('businessregistration::businessregistration.upload_application_letter') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Tab Content -->
        <div class="col-md-9">
            <div class="card">

                <div class="card-body">
                    <div class="tab-content" id="v-pills-tabContent">
                        <!-- application-letter -->
                        <div class="tab-pane fade {{ $activeTab === 'application-letter' ? 'show active' : '' }}"
                            id="v-pills-application-letter" role="tabpanel"
                            aria-labelledby="v-pills-application-letter-tab">
                            <div class="d-flex align-items-center justify-content-between flex-wrap">
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled"
                                        wire:click="writeApplicationLetter">
                                        <i class="bx bx-save"></i>
                                        {{ __('businessregistration::businessregistration.save') }}
                                    </button>
                                    <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled"
                                        wire:click="resetLetter">
                                        <i class="bx bx-reset"></i>
                                        {{ __('businessregistration::businessregistration.reset') }}
                                    </button>
                                    <!-- Toggle Preview/Edit Mode -->
                                    <div class="d-flex align-items-center gap-2">
                                        <label class="form-label mb-0" for="previewToggle">
                                            {{ $preview ? __('businessregistration::businessregistration.preview') : __('businessregistration::businessregistration.edit') }}
                                        </label>
                                        <div class="form-check form-switch mb-0">
                                            <input type="checkbox" id="previewToggle" class="form-check-input"
                                                style="width: 3rem; height: 1.3rem;" wire:model="editMode"
                                                wire:click="togglePreview">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    @if ($preview)
                                        <button class="btn btn-outline-primary" type="button"
                                            wire:click="printApplicationLetter">
                                            <i class="bx bx-printer"></i>
                                            {{ __('businessregistration::businessregistration.print') }}
                                        </button>
                                    @endif
                                </div>

                            </div>
                            <hr>
                            <div class="col-md-12 {{ $preview ? 'd-none' : '' }}">
                                <x-form.ck-editor-input label="" id="application_letter"
                                    name="applicationTemplate" :value="$applicationTemplate"
                                    wire:model.defer="applicationTemplate" />
                            </div>

                            <div class="{{ !$preview ? 'd-none' : '' }}" id="applicationContent">
                                {!! $applicationTemplate !!}
                                <style>
                                    {!! $style !!}
                                </style>

                            </div>
                        </div>

                        <!-- Documents Tab -->
                        <div class="tab-pane fade {{ $activeTab === 'documents' ? 'show active' : '' }}"
                            id="v-pills-documents" role="tabpanel" aria-labelledby="v-pills-documents-tab">

                            <form wire:submit.prevent="saveApplicationLetter">
                                <div class="row">
                                    {{-- <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="documentLabelEn" class="form-label">Document Label
                                                (English)</label>
                                            <input type="text" class="form-control" id="documentLabelEn"
                                                wire:model="businessRequiredDoc.document_label_en">
                                            @error('businessRequiredDoc.document_label_en')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div> --}}
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="documentLabelNe"
                                                class="form-label">{{ __('businessregistration::businessregistration.document_label_nepali') }}</label>
                                            <input type="text" class="form-control" id="documentLabelNe"
                                                wire:model="businessRequiredDoc.document_label_ne" readonly>
                                            @error('businessRequiredDoc.document_label_ne')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="applicationFile"
                                                class="form-label">{{ __('businessregistration::businessregistration.select_file') }}</label>
                                            <input type="file" class="form-control" id="applicationFile"
                                                wire:model="applicationFile">
                                            <div wire:loading wire:target="applicationFile">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                {{ __('businessregistration::businessregistration.uploading') }}
                                            </div>

                                            @if ($applicationFileUrl)
                                                <a href="{{ $applicationFileUrl }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary mt-2">
                                                    <i class="bx bx-file"></i>
                                                    {{ __('businessregistration::businessregistration.view_uploaded_file') }}
                                                </a>
                                            @endif
                                            @error('applicationFile')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                            <i class="fas fa-upload me-2"></i>
                                            {{ __('businessregistration::businessregistration.upload_document') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        #applicationContent {
            width: 210mm;
            min-height: 297mm;
            padding: 7mm 10mm;
            margin: auto;
            background: white;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
            position: relative;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    {{-- this script lets user download the pdf --}}
    <script>
        async function printDiv() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById('applicationContent');

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

        // Listen for Livewire print event
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-application-letter', () => {

                printDiv();
            });


        });
    </script>

</div>
