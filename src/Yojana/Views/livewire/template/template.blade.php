<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5><strong>{{ __('yojana::yojana.subject__') }}</strong>{{ __($model->subject) }}</h5>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center gap-2 flex-wrap">

                {{-- Input Fields Mode --}}
                @if ($editorMode == 'input')
                    <button class="btn btn-outline-danger" wire:click="deleteDynamicData">
                        {{ __('yojana::yojana.delete_data') }}
                    </button>
                @endif

                @if ($editorMode == 'ck' || $editorMode == 'preview')
                    <button class="btn btn-outline-primary" type="submit" wire:click="save" wire:loading.attr="disabled">
                        <i class="bx bx-save"></i> {{ __('yojana::yojana.save') }}
                    </button>

                    <button class="btn btn-outline-primary" type="button" wire:click="resetLetter"
                        wire:loading.attr="disabled">
                        <i class="bx bx-reset"></i> {{ __('yojana::yojana.reset') }}
                    </button>
                @endif

            </div>

            <div class="d-flex align-items-center mb-3">

                <div class="d-flex border rounded overflow-hidden">
                    {{-- Input Fields --}}
                    <button type="button"
                        class="flex-fill btn {{ $editorMode == 'input' ? 'btn-primary text-white' : 'btn-light' }}"
                        wire:click="setEditorMode('input')">
                        {{ __('yojana::yojana.input_fields') }}
                    </button>

                    {{-- Preview Text --}}
                    <button type="button"
                        class="flex-fill btn {{ $editorMode == 'preview' ? 'btn-primary text-white' : 'btn-light' }}"
                        wire:click="setEditorMode('preview')">
                        {{ __('yojana::yojana.preview_text') }}
                    </button>

                    {{-- CKEditor --}}
                    <button type="button"
                        class="flex-fill btn {{ $editorMode == 'ck' ? 'btn-primary text-white' : 'btn-light' }}"
                        wire:click="setEditorMode('ck')">
                        {{ __('yojana::yojana.ck_editor') }}
                    </button>
                </div>
            </div>

            <div>
                @if ($editorMode != 'input')
                    {{-- Print Button --}}
                    <button type="button" class="btn btn-outline-primary btn-info" onclick="printDiv()"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('yojana::yojana.print_form') }}">
                        <i class="bx bx-printer"></i> {{ __('yojana::yojana.print') }}
                    </button>
                @endif

            </div>

        </div>

    </div>

    <div class="col-md-12 {{ $preview ? 'd-none' : '' }}">
        <x-form.ck-editor-input label="" id="recommendation_letter" name="letter" :value="$letter" />
    </div>
    <div class=" mt-3 {{ !$preview ? 'd-none' : '' }}">
        <div class="card-body">
            <div class="col-md-12 a4-container" id="printContent">
                {!! $letter !!}
            </div>
        </div>
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
    </style>

</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-pdf-in-new-tab', (event) => {
                console.log(event);
                window.open(event.url, '_blank');
            });

            Livewire.on('refresh-page', (event) => {
                location.reload();
            });

        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
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
    </script>

    {{-- this script lets user download the pdf --}}
    <!-- <script>
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
    </script> -->
@endpush
