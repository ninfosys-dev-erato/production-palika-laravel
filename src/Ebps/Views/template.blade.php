<x-layout.app>
    <div class="container mt-3">

        <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-info" onclick="history.back()">
                <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
            </button>
            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-danger" onclick="printDiv()" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Print">
                    <i class="bx bx-printer"></i> {{ __('ebps::ebps.print') }}
                </button>
            </div>
        </div>

        <div class="col-md-12">
            <div style="border-radius: 10px; text-align: center; padding: 20px;">
                <div id="printContent" class="a4-container">

                    <style>
                        {{ $form->styles ?? '' }}
                    </style>

                    {!! str_replace(
                        '@{{global.letter-head}}',
                        getLetterHeaderTest(null, getFormattedBsDate(), null, true, null),
                        $form->template,
                    ) !!}

                </div>
            </div>
        </div>

    </div>
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
</x-layout.app>

<style>
    /* Ensure A4 Size */
    .a4-container {
        width: 210mm;
        min-height: 297mm;
        padding: 20mm;
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
            padding: 20mm;
            page-break-after: always;
        }
    }
</style>
