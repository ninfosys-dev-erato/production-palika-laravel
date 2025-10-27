<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            {{-- <div class="d-flex align-items-center gap-2 flex-wrap">
                <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:click="save">
                    <i class="bx bx-save"></i> {{ __('ejalas::ejalas.save') }}
                </button>
                <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled"
                    wire:click="resetLetter">
                    <i class="bx bx-reset"></i> {{ __('ejalas::ejalas.reset') }}
                </button>
                <div class="d-flex align-items-center">
                    <label for="" class="mb-0">{{ __('ejalas::ejalas.edit_mode') }}&nbsp;</label>
                    <div class="form-check form-switch mb-0">
                        <input type="checkbox" class="form-check-input" {{ !$preview ? 'checked' : '' }}
                            wire:click="togglePreview">
                    </div>
                </div>
            </div> --}}

            <div>
                <button type="button" class="btn btn-outline-primary btn-info" onclick="printDiv()"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('ejalas::ejalas.print_form') }}">
                    <i class="bx bx-printer"></i> {{ __('ejalas::ejalas.print') }}
                </button>
            </div>

        </div>
    </div>

    {{-- <div class="col-md-12 {{ $preview ? 'd-none' : '' }}">
        <x-form.ck-editor-input label="" id="recommendation_letter" name="letter" :value="$letter" />
    </div> --}}
    {{-- <div class="card mt-3 {{ !$preview ? 'd-none' : '' }}"> --}}

    <div class="col-md-12">
        <div style="border-radius: 10px; text-align: center; padding: 20px;">
            <div id="printContent" class="a4-container">
                {!! $letter !!}
            </div>
        </div>
    </div>

    {{-- renders style fetched from the template --}}
    {!! $style !!}
</div>
@push('styles')
    <style>
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: auto;
            background: white;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            text-align: left;
            color: #333;
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
@endpush
@push('scripts')
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
@endpush
