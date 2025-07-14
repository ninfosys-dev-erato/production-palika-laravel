<div>
    <div class="container mt-3">
        <div class="d-flex justify-content-between align-items-center">
            <button type="button" class="btn btn-info" onclick="history.back()">
                <i class="bx bx-arrow-back"></i> {{ __('ebps::ebps.back') }}
            </button>

            <button type="button" class="btn btn-danger" onclick="printDiv()" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Print">
                <i class="bx bx-printer"></i> {{ __('ebps::ebps.print') }}
            </button>
        </div>

        <div class="col-md-12 mt-3">
            <div style="border-radius: 10px; padding: 20px;">
                <div id="printContent" class="a4-container">

                    <p>
                        श्रीमान प्रमुख प्रशासकीय अधिकृतज्यू,<br>
                        {{ getSetting('local_level_type') }} {{ getSetting('palika-name') }}<br>
                        {{ getSetting('palika-address') }}
                    </p>

                    <h5 class="text-center">विषय: कन्सल्टेन्सी परिवर्तन सम्बन्धमा।</h5>

                    <p>महोदय,</p>

                    <p>
                        प्रस्तुत विषयमा यसै पत्रमार्फत जानकारी गराउन चाहन्छु कि म {{ $mapApply->full_name }},
                        स्थायी ठेगाना {{ $mapApply->localBody->title }}, वार्ड नं. {{ $mapApply->ward_no }}
                        हाल मेरो स्वामित्वमा रहेको घरको नक्सा पास कार्यका लागि पहिले
                        "{{ $oldOrganizationDetail->org_name_ne ?? 'N/A' }}"
                        (पहिलेको कन्सल्टेन्सी नाम)** बाट प्राविधिक सेवा लिईएको थियो।
                    </p>

                    <p>
                        हाल विशेष कारणबस (जस्तै: सेवा सुविधा, कार्य क्षमताको आधारमा, पारस्परिक समझदारी आदि),
                        उक्त कन्सल्टेन्सीलाई परिवर्तन गरी "{{ $organization->org_name_ne ?? 'N/A' }}"
                        (नयाँ कन्सल्टेन्सीको नाम) मार्फत काम अगाडि बढाउन चाहेको हुँदा, यस कार्यको लागि
                        कन्सल्टेन्सी परिवर्तन स्वीकृति प्रदान गरिदिनुहुन अनुरोध गर्दछु।
                    </p>

                    <h6 class="section-title mt-4">पहिले नक्सा पास विवरण:</h6>
                    <p>• नक्सा पास नं.: {{ $mapApply->submission_id }}</p>
                    <p>• नक्सा पास मिति: </p>
                    <p>• स्थलगत स्थान: </p>
                    <p>• प्राविधिकको नाम: {{ $oldOrganizationDetail->org_name_ne ?? '' }}</p>

                    <h6 class="section-title mt-4">संलग्न कागजातहरू:</h6>
                    <ol>
                        <li>पुरानो कन्सल्टेन्सीको राजीनामा/स्वीकृति पत्र</li>
                        <li>नयाँ कन्सल्टेन्सीको स्वीकृति पत्र</li>
                        <li>नक्सापास प्रमाणपत्रको प्रतिलिपि</li>
                        <li>घरधनीको नागरिकताको प्रतिलिपि</li>
                        <li>अन्य आवश्यक कागजातहरू</li>
                    </ol>

                    <p>
                        उपर्युक्त आधारमा नयाँ कन्सल्टेन्सीमार्फत नक्सा पास सम्बन्धी कार्य अगाडि बढाउन
                        अनुमति प्रदान गरिदिनुहुन हार्दिक अनुरोध गर्दछु।
                    </p>

                    <h6 class="section-title mt-4">सादर,</h6>

                    <h6 class="section-title">घरधनीको विवरण:</h6>
                    <p>नाम: {{ $mapApply->full_name }}</p>
                    <p>नागरिकता नं.: {{ $mapApply->houseOwner->citizenship_no ?? '______________________________' }}
                    </p>
                    <p>सम्पर्क नं.: {{ $$mapApply->houseOwner->mobile_no ?? '______________________________' }}</p>
                    <p>ठेगाना: {{ $mapApply->houseOwner->localBody->title ?? '______________________________' }}, वडा
                        नं.
                        {{ $mapApply->houseOwner->ward_no ?? '______________________________' }}</p>
                    <p>मिति: {!! getFormattedBsDate() !!}</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        .a4-container {
            width: 210mm;
            min-height: 297mm;
            padding: 25mm;
            margin: 0 auto;
            background: #fff;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            font-family: 'Mangal', 'Kalimati', Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            box-sizing: border-box;
        }

        .letter-body p {
            margin-top: 4px;
            margin-bottom: 4px;
        }

        h5 {
            text-decoration: underline;
            font-weight: bold;
            margin: 15px 0;
        }

        .section-title {
            font-weight: bold;
            text-decoration: underline;
            margin-top: 10px;
        }

        ol {
            padding-left: 18px;
        }

        @media print {

            .btn,
            .container>.d-flex {
                display: none !important;
            }

            .a4-container {
                box-shadow: none;
                margin: 0;
                padding: 25mm;
                page-break-after: always;
            }
        }
    </style>

</div>

<script>
    function printDiv() {
        const printContent = document.getElementById('printContent');
        if (!printContent) {
            alert('No content found for printing.');
            return;
        }
        @this.call('printTemplate', printContent.innerHTML);
    }
</script>
