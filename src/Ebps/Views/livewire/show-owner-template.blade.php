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

        <div class="container mt-3">
            <div class="col-md-12 mt-3">
                <div style="border-radius: 10px; padding: 20px;">
                    <div id="printContent" class="a4-container">

                        <br><br>

                        <!-- Letter Body -->
                        <div class="letter-body">
                            <p>श्रीमान् प्रमुख प्रशासकीय अधिकृतज्यू,<br>
                                <strong>{{ getSetting('palika-name') }}</strong><br>
                                <strong>{{ getSetting('palika-address') }}</strong>
                            </p>

                            <h5 class="text-center">विषय: घरधनी नामसारी (परिवर्तन) सम्बन्धमा निवेदन</h5>

                            <p>महोदय,</p>

                            <p>प्रस्तुत विषयमा मेरो {{ $oldHouseOwnerDetail->owner_name }} नाममा रहेको घर/जग्गा
                                अर्को व्यक्तिको नाममा कानुनी प्रक्रिया अनुसार ट्रान्सफर (नामसारी) गर्न चाहेको हुँदा,
                                स्थानीय तहको प्रचलित नियमअनुसार नामसारीको प्रक्रिया अगाडि बढाइदिनुहुन निवेदन गर्दछु।
                            </p>

                            <div style="display: flex; justify-content: space-between; margin: 20px 0;">
                                <div style="width: 48%; padding-right: 10px;">
                                    <h6 style="text-decoration: underline;">पुरानो घरधनीको विवरण:</h6>
                                    <p>नाम: <span>{{ $oldHouseOwnerDetail->owner_name }}</span></p>
                                    <p>ठेगाना: <span>{{ $oldHouseOwnerDetail->localBody->title }}</span></p>
                                    <p>नागरिकता नं.: <span>{{ $oldHouseOwnerDetail->citizenship_no }}</span></p>
                                </div>
                                <div style="width: 48%; padding-right: 10px;">
                                    <h6 style="text-decoration: underline;">नयाँ घरधनीको विवरण:</h6>
                                    <p>नाम: <span>{{ $houseOwnerDetail->owner_name }}</span></p>
                                    <p>ठेगाना: <span>{{ $houseOwnerDetail->localBody->title }}</span></p>
                                    <p>नागरिकता नं.: <span>{{ $houseOwnerDetail->citizenship_no }}</span></p>
                                </div>
                            </div>

                            <!-- Reason -->
                            <h6 class="section-title">नामसारीको कारण:</h6>
                            <p>

                                {{ $houseOwnerDetail->reason_of_owner_change }}
                            </p>

                            <!-- Documents -->
                            <h6 class="section-title">संलग्न कागजातहरू:</h6>
                            <ul>
                                <li>नक्सा पास प्रमाणपत्रको प्रतिलिपि</li>
                                <li>बिक्री सम्झौता/अंशबण्डा पत्र/उपहार पत्र</li>
                                <li>दुवै पक्षको नागरिकताको प्रतिलिपि</li>
                                <li>रितपूर्वक भरिएको नामसारी फारम</li>
                                <li>राजस्व तिरेको रसिद</li>
                                <li>अन्य आवश्यक कागजातहरू</li>
                            </ul>

                            <p>अतः, उपर्युक्त विवरण एवं कागजातहरूको आधारमा नक्सा पास नामसारी प्रक्रिया अघि
                                बढाइदिनुहुन विनम्र अनुरोध गर्दछु।
                            </p>

                            <br>
                            <br>

                            <!-- Signature -->
                            <h6 class="section-title">निवेदकको विवरण:</h6>
                            <p>नाम: <span>{{ $oldHouseOwnerDetail->owner_name }}</span></p>
                            <p>मिति: <span>{!! getFormattedBsDate() !!}</span></p>
                            <p>सम्पर्क नं.: <span>{{ $oldHouseOwnerDetail->mobile_no }}</span></p>
                        </div>

                    </div>
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
            line-height: 1.4;
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

        .col-6:first-child {
            border-right: 1px dashed #999;
            padding-right: 20px;
        }

        .col-6:last-child {
            padding-left: 20px;
        }


        .section-title {
            font-weight: bold;
            text-decoration: underline;
        }

        .section-header-pair {
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .section-header-pair .section-title {
            flex: 1;
        }

        .section-header-pair .section-title.text-end {
            text-align: right;
        }

        @media print {
            .btn {
                display: none !important;
            }

            .a4-container {
                box-shadow: none;
                margin: 0;
                padding: 25mm;
                page-break-after: always;
            }

            .btn,
            .container>.d-flex {
                display: none !important;
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
