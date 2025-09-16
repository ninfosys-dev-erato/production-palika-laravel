<div class="row">

    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header">
                <h5><strong>{{__('yojana::yojana.subject__')}}</strong>{{__($model->subject)}}</h5>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:click="save">
                    <i class="bx bx-save"></i> {{ __('yojana::yojana.save') }}
                </button>
                <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled"
                    wire:click="resetLetter">
                    <i class="bx bx-reset"></i> {{ __('yojana::yojana.reset') }}
                </button>
                <div class="d-flex align-items-center">
                    <label for="" class="mb-0">{{ __('yojana::yojana.edit_mode') }}&nbsp;</label>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" {{ !$preview ? 'checked' : '' }}
                            wire:click="togglePreview">
                    </div>
                </div>
            </div>

            <div>
                <button type="button" class="btn btn-outline-primary btn-info"
                    onclick="printDiv()" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ __('yojana::yojana.print_form') }}">
                    <i class="bx bx-printer"></i> {{ __('yojana::yojana.print') }}
                </button>
            </div>

        </div>
    </div>

    <div class="col-md-12 {{ $preview ? 'd-none' : '' }}">
        <x-form.ck-editor-input label="" id="recommendation_letter" name="letter" :value="$letter" />
    </div>
    <div class="card mt-3 {{ !$preview ? 'd-none' : '' }}">
        <div class="card-body">
            <div class="col-md-12" id="printContent">
                {!! $letter !!}
            </div>
        </div>
    </div>


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
