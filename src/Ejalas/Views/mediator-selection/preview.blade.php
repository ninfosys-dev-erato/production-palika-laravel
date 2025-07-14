<x-layout.app>
    <livewire:ejalas.template_form :model="$mediatorSelection" />
</x-layout.app>


{{-- <x-layout.app header="{{ __('ejalas::ejalas.print') }}">
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <button type="button" class="btn btn-info" onclick="history.back()">
                <i class="bx bx-arrow-back"></i> {{ __('ejalas::ejalas.back') }}
            </button>
            <button type="button" class="btn btn-danger" onclick="printDiv()" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Print">
                <i class="bx bx-printer"></i> {{ __('ejalas::ejalas.print') }}
            </button>
        </div>

        <div class="col-md-12">
            <div class="a4-container">
                <div id="printContent" class="a4-content">
                    <header class="text-center">
                        <p>
                            {{ getSetting('palika-name') }} <br>
                            न्यायिक समितिको सचिवालय <br>
                            {{ getSetting('palika-address') }} <br>
                        </p>
                    </header>

                    <div>
                        <strong>श्री न्यायिक समिति,</strong>
                        <strong>{{ getSetting('palika-address') }}</strong> <br>

                        <strong class="text-center">मेलमिलापकर्ता छनौट सम्बन्धमा ।</strong>

                    </div>
                    <div class="container mt-3">
                        <div class="row d-flex align-items-end">
                            <div class="col-md-6">
                                <h5>निवेदक (प्रथम पक्ष)</h5>
                                @if ($complainers->isNotEmpty())
                                    @foreach ($complainers as $complainer)
                                        <p><strong>{{ $complainer->name }}</strong></p>
                                        <p>{{ $complainer->permanentDistrict->title }} जिल्ला,
                                            {{ $complainer->permanentLocalBody->title }} वडा नं
                                            {{ $complainer->permanent_ward_id }},
                                            {{ $complainer->permanent_tole }}
                                        </p>
                                    @endforeach
                                @else
                                    <p>निवेदकको विवरण उपलब्ध छैन।</p>
                                @endif
                            </div>

                            <div class="col-md-6 text-end">
                                <h5>विपक्ष (दोश्रो पक्ष)</h5>
                                @if ($defenders->isNotEmpty())
                                    @foreach ($defenders as $defender)
                                        <p><strong>{{ $defender->name }}</strong></p>
                                        <p>{{ $defender->permanentDistrict->title }} जिल्ला,
                                            {{ $defender->permanentLocalBody->title }} वडा नं
                                            {{ $defender->permanent_ward_id }},
                                            {{ $defender->permanent_tole }}
                                        </p>
                                    @endforeach
                                @else
                                    <p>विपक्षको विवरण उपलब्ध छैन।</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <p><strong>विवाद/मुद्दा :</strong>
                        {{ $complaint->disputeMatter->disputeArea->title . ' ' . $complaint->disputeMatter->title . ' ' . $complaint->subject }}
                    </p>


                </div>
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
        font-family: 'Arial', sans-serif;
        line-height: 1.6;
    }

    .nepali-list {
        list-style: none;
    }

    .nepali-list li {
        margin-bottom: 10px;

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
</script> --}}
