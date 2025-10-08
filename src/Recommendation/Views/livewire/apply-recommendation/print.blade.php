<div class="row">

    <div class="col-md-12">
    <div class="d-flex align-items-center gap-2 flex-wrap w-100 justify-content-between">
        <!-- Left-aligned buttons -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:click="save">
                <i class="bx bx-save"></i> {{ __('recommendation::recommendation.save') }}
            </button>
            <button class="btn btn-outline-primary" type="submit" wire:loading.attr="disabled" wire:click="resetLetter">
                <i class="bx bx-reset"></i> {{ __('recommendation::recommendation.reset') }}
            </button>
            <div class="d-flex align-items-center">
                <label for="" class="mb-0">{{ __('recommendation::recommendation.edit_mode') }}&nbsp;</label>
                <div class="form-check form-switch mb-0">
                    <input type="checkbox" class="form-check-input" {{ !$preview ? 'checked' : '' }}
                        wire:click="togglePreview">
                </div>
            </div>
        </div>

        <div>
            @if($applyRecommendation->status == Src\Recommendation\Enums\RecommendationStatusEnum::ACCEPTED)
            <button type="button" class="btn btn-info" onclick="printRecDiv()"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                <i class="bx bx-printer"></i> {{ __('recommendation::recommendation.print') }}
            </button>
            @endif
        </div>
    </div>
</div>


    <div class="col-md-12 {{ $preview ? 'd-none' : '' }}">
{{--        <x-form.ck-editor-input label="" id="recommendation_letter" name="letter" :value="$letter" />--}}
        <x-form.summernote-editor label="" id="recommendation_letter" name="letter" :value="$letter"/>
    </div>



    <div class="col-md-12 {{ !$preview ? 'd-none' : '' }}">
            <div style="border-radius: 10px; text-align: center; padding: 20px;">
                <div id="printContent" class="a4-container">
                {!! $letter . $styles !!}
                @php
                $watermark = getSetting('palika-campaign-logo');
            @endphp

            @if (!empty($watermark) && getSetting('show-letter-watermark'))
                <img class="watermark" src="{{ $watermark }}" alt="Watermark">
            @endif
                </div>
            </div>
        </div>

        <style>
         @font-face {
        font-family: 'Kalimati';
        src: url('/fonts/Kalimati.ttf') format('truetype');
        font-weight: normal;
        font-style: normal;
    }

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
            font-family: 'Kalimati' !important;
            font-size: 15px;
            color: #000;
        }



     .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        opacity: 0.1; /* Adjust transparency here */
        width: 60%;
        height: 40%;
        z-index: 0; /* Ensure it stays behind text */
        pointer-events: none; /* So it doesn't interfere with interaction */
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
                padding: 20mm;
                page-break-after: always;
            }
        }
    </style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    {{-- this script lets user download the pdf --}}
    <script>
        async function printRecDiv() {
          
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

    </script>

</div>
