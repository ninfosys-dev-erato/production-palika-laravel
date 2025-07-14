<x-layout.app>
    <div class="container mt-3">

        <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-info" onclick="history.back()">
                <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
            </button>
            <a href="{{ route('admin.ebps.print', ['formId' => $form->id]) }}" target="_blank" class="btn btn-danger"
                data-bs-toggle="tooltip" data-bs-placement="top" title="Print">
                <i class="bx bx-printer"></i> {{ __('ebps::ebps.print') }}
            </a>
        </div>

        <div class="col-md-12">
            <div style="border-radius: 10px; text-align: center; padding: 20px;">
                <div id="printContent" class="a4-container">

                    <style>
                        {{ $formStyle ?? '' }}
                    </style>

                    {!! $form->template !!}
                </div>
            </div>
        </div>

    </div>
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

<script>
    function printDiv() {
        const printContent = document.getElementById('printContent');
        if (!printContent) {
            alert('No content found for printing.');
            return;
        }

        const printContents = printContent.innerHTML;
        const originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;
        setTimeout(() => {
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }, 100);
    }
</script>
