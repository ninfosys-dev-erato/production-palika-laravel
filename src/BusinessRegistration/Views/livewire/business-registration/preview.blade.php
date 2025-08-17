<div>
    <div class="container mt-3">
        {{-- <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-info" onclick="history.back()">
                <i class="bx bx-arrow-back"></i> {{ __('businessregistration::businessregistration.back') }}
            </button>
            <button type="button" class="btn btn-info" onclick="printDiv()" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Print">
                <i class="bx bx-printer"></i> {{ __('businessregistration::businessregistration.print') }}
            </button>
        </div> --}}
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button class="btn btn-outline-primary" type="button" wire:loading.attr="disabled"
                    wire:click="writeCertificateLetter">
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
                            style="width: 3rem; height: 1.3rem;" wire:model="editMode" wire:click="togglePreview">
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                @if ($preview)
                    <button class="btn btn-outline-primary" type="button" wire:click="printCertificateLetter">
                        <i class="bx bx-printer"></i>
                        {{ __('businessregistration::businessregistration.print') }}
                    </button>
                @endif
            </div>

        </div>


        <hr>
        <div class="col-md-12  {{ $preview ? 'd-none' : '' }}">
            <x-form.ck-editor-input label="" id="certificate_letter" name="certificateTemplate" :value="$certificateTemplate"
                wire:model.defer="certificateTemplate" />
        </div>
        <div class="col-md-12">
            <div style="border-radius: 10px; text-align: center; padding: 20px;">

                <div class="{{ !$preview ? 'd-none' : '' }} a4-container" id="printContent">
                    {!! $certificateTemplate !!}
                    <style>
                        {!! $style !!}
                    </style>

                </div>
            </div>
        </div>


        {{-- <div class="col-md-12">
            <div style="border-radius: 10px; text-align: center; padding: 20px;">


                <div id="printContent" class="a4-container">
                    <style>
                        {{ $style }}
                    </style>
                    {!! $template !!}
                </div>
            </div>
        </div> --}}
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
            position: relative;
        }

        /* Print Styling */
        /* @media print {
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
                padding: 20mm;
                page-break-after: always;
            }
        } */
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    {{-- this script lets user download the pdf --}}
    <script>
        async function printDiv() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById('printContent');


            const canvas = await html2canvas(element, {
                scale: 2,
                useCORS: true,
            });

            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');

            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = pdf.internal.pageSize.getHeight();

            const imgProps = pdf.getImageProperties(imgData);
            const imgHeight = (imgProps.height * pdfWidth) / imgProps.width;

            let heightLeft = imgHeight;
            let position = 0;

            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
            heightLeft -= pdfHeight;

            // Only add more pages if the image is taller than one page
            while (heightLeft > 1) {
                position -= pdfHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, imgHeight);
                heightLeft -= pdfHeight;
            }
            pdf.save("certificate.pdf");
        }
        // Listen for Livewire print event
        document.addEventListener('livewire:init', () => {
            Livewire.on('print-certificate-letter', () => {

                printDiv();
            });


        });
    </script>


    {{-- this script opens the new tab and let user print or download the certificate --}}

    {{-- <script>
        async function printDiv() {
            const {
                jsPDF
            } = window.jspdf;
            const element = document.getElementById('printContent');

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
    </script> --}}

</div>
