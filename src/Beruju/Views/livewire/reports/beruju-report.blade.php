<div>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="text-primary fw-bold mb-0">{{ __('beruju::beruju.beruju_report') }}</h4>
        <div class="d-flex gap-2 ms-auto">
            <button type="button" wire:click="export" class="btn btn-outline-primary btn-sm">
                {{ __('beruju::beruju.export') }}
            </button>
            <button type="button" onclick="printDiv()" class="btn btn-outline-primary btn-sm">
                {{ __('beruju::beruju.print') }}
            </button>
        </div>
    </div>



    {{-- Results Table --}}
    <div>
        @if ($berujuEntries && $berujuEntries->count())
            <!-- Official Report Header -->
            <div class="container mt-4">
                <div class="card shadow" id="printContent">
                    <!-- Report Header -->
                    <div class="card-header bg-white border-0">
                        <div class="row">

                            <!-- Main Title -->
                            <div class="text-center mt-3 mb-5">
                                <h4 class="mb-2"><strong>अनुसूची - १</strong></h4>
                                <h5 class="mb-3"><strong>आन्तरिक/अन्तिम लेखापरीक्षणबाट कायम बेरुजुको लगत खाता
                                        (म.ले.प.फा.नं. ८०१)</strong></h5>
                            </div>

                            <!-- Left Side - Government Hierarchy -->
                            <div class="col-md-3 ">
                                <div class="text-start">
                                    <div class="border border-dark p-4 col-md-6" style="width: 150px;">
                                        <p class="mb-1">
                                            <strong>नेपाल सरकार/</strong>
                                        </p>
                                        <p class="mb-1"><strong>प्रदेश</strong></p>
                                        <p class="mb-1"><strong>सरकार/स्थानीय</strong></p>
                                        <p class="mb-1"><strong>सरकारको छाप</strong></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 text-center">
                                <p class="mb-1"><strong>सङ्घ । प्रदेश / स्थानीय तह</strong></p>
                                <p class="mb-1"><strong>.......... मन्त्रालय/विभाग/कार्यालय</strong></p>
                                <p class="mb-1"><strong>कार्यालय कोड नं.:</strong></p>
                            </div>

                            <!-- Right Side - Form Number -->
                            <div class="col-md-3">
                                <div class="text-center">
                                    <p class="mb-1"><strong>म.ले.प.फाराम नः ८०१</strong>
                                        <br>
                                        <strong>साबिकको फारम नं:</strong>
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p class="mb-1"><strong>आन् तररक/अवन् ति लेखापरीक्ष णबाट कायि बेरु जनको लगत
                                        खाता</strong></p>
                                <p class="mb-1"><strong>२०..........साल .........महिना</strong></p>
                            </div>
                        </div>


                        <!-- Report Period and Fund Type -->
                        <div class="row mt-5">
                            <div class="col-md-3 ">
                                <p class="mb-1"><strong>बजेट उपशीर्षक / कारोबार नं.:</strong></p>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="me-3">
                                        <input type="checkbox" class="form-check-input me-1"> <strong>विनियोजन</strong>
                                        <input type="checkbox" class="form-check-input me-1 ms-2">
                                        <strong>राजस्व</strong>
                                    </div>
                                    <div class="me-3">
                                        <input type="checkbox" class="form-check-input me-1"> <strong>धरौटी</strong>
                                        <input type="checkbox" class="form-check-input me-1 ms-2"> <strong>अन्य
                                            कोष</strong>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div>
                                    <strong>खाता पाना नं:</strong>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <p class="mb-1"><strong>आर्थिक वर्ष :</strong></p>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0" id="print-content">
                                <thead>
                                    <tr>
                                        <th rowspan="2">{{ __('beruju::beruju.sn') }}</th>
                                        <th rowspan="2">{{ __('beruju::beruju.fiscal_year') }}</th>
                                        <th rowspan="2">{{ __('beruju::beruju.dafa_number') }}</th>
                                        <th rowspan="2">भौचर नं.</th>
                                        <th rowspan="2">बेरुजुको सङ्क्षिप्त व्यहोरा</th>
                                        <th rowspan="2">{{ __('beruju::beruju.owner_name') }}</th>
                                        <th rowspan="2">{{ __('beruju::beruju.contract_number') }}</th>
                                        <th rowspan="2">{{ __('beruju::beruju.sub_category') }}</th>


                                        <!-- Parent headers with sub-columns -->
                                        <th colspan="4" class="text-center">कायम भएको बेरुजु रकम</th>
                                        <th colspan="4" class="text-center">सम्परीक्षण भएको</th>
                                        <th colspan="4" class="text-center">बाँकी बेरुजु</th>

                                        <th rowspan="2">कैफियत</th>
                                    </tr>
                                    <tr>
                                        <!-- Subheadings -->
                                        <th>नियमित गर्नुपर्ने </th>
                                        <th>पेस्की </th>
                                        <th>असुल उपर गर्नुपर्ने</th>
                                        <th>जम्मा</th>

                                        <th>नियमित गर्नुपर्ने </th>
                                        <th>पेस्की </th>
                                        <th>असुल उपर गर्नुपर्ने</th>
                                        <th>जम्मा</th>

                                        <th>नियमित गर्नुपर्ने </th>
                                        <th>पेस्की </th>
                                        <th>असुल उपर गर्नुपर्ने</th>
                                        <th>जम्मा</th>
                                    </tr>
                                    <tr>
                                        <th>{{ replaceNumbersWithLocale(1, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(2, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(3, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(4, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(5, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(6, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(7, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(8, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(9, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(10, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(11, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(12, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(13, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(14, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(15, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(16, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(17, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(18, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(19, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(20, true) }}</th>
                                        <th>{{ replaceNumbersWithLocale(21, true) }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php
                                        $totalAmount = 0;
                                    @endphp
                                    @foreach ($berujuEntries as $index => $row)
                                        <tr>
                                            <td>{{ replaceNumbersWithLocale($index + 1, true) }}</td>
                                            <td>{{ $row->fiscalYear->year ?? __('beruju::beruju.na') }}</td>
                                            <td>{{ replaceNumbersWithLocale($row->dafa_number, true) ?? __('beruju::beruju.na') }}
                                            </td>
                                            <td>{{ replaceNumbersWithLocale($row->reference_number, true) ?? __('beruju::beruju.na') }}
                                            </td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->owner_name ?? __('beruju::beruju.na') }}</td>
                                            <td>{{ replaceNumbersWithLocale($row->contract_number, true) ?? __('beruju::beruju.na') }}
                                            </td>
                                            <td>{{ $row->subCategory->name_nep ?? __('beruju::beruju.na') }}</td>
                                            <td>
                                                @if ($row->sub_category_id == 2 || $row->subCategory->parent_id == 2)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->sub_category_id == 4 || $row->subCategory->parent_id == 4)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->sub_category_id == 1 || $row->subCategory->parent_id == 1)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ replaceNumbersWithLocale(number_format((float) $row->amount, 2), true) }}
                                            </td>

                                            <td>
                                                @if ($row->sub_category_id == 2 || $row->subCategory->parent_id == 2)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->resolved_amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->sub_category_id == 4 || $row->subCategory->parent_id == 4)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->resolved_amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->sub_category_id == 1 || $row->subCategory->parent_id == 1)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->resolved_amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ replaceNumbersWithLocale(number_format((float) $row->resolved_amount, 2), true) }}
                                            </td>

                                            <td>
                                                @if ($row->sub_category_id == 2 || $row->subCategory->parent_id == 2)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->remaining_amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->sub_category_id == 4 || $row->subCategory->parent_id == 4)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->remaining_amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if ($row->sub_category_id == 1 || $row->subCategory->parent_id == 1)
                                                    {{ replaceNumbersWithLocale(number_format((float) $row->remaining_amount, 2), true) }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ replaceNumbersWithLocale(number_format((float) $row->remaining_amount, 2), true) }}
                                            </td>
                                            <td>{{ $row->beruju_description ?? __('beruju::beruju.na') }}</td>
                                        </tr>
                                        @php
                                            $totalAmount += (float) ($row->amount ?? 0);
                                        @endphp
                                    @endforeach
                                    <tr>
                                        <td class="text-right"><strong>जम्मा</strong></td>
                                        <!-- <td><strong>{{ replaceNumbersWithLocale(number_format($totalAmount, 2), true) }}</strong></td> -->
                                        <td colspan="20"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Report Footer -->
                        <div class="card-footer bg-white border-0">
                            <!-- Note Section -->
                            <div class="mt-4 mb-4">
                                <p class="mb-2"><strong>नोटः</strong>
                                    आन्तरिक लेखा परीक्षण र अन्तिम लेखा परीक्षण बेरुजुको लगत छुट्टा छुट्टै खातामा राख्नु
                                    पर्दछ। साथै कारोबारको प्रकृतिअनुसार छुट्टा छुट्टै पानामा अभिलेख राख्नुपर्दछ ।
                                </p>
                            </div>

                            <!-- Signature Blocks -->
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <div class="p-3 text-center" style="min-height: 120px;">
                                        <p class="mb-2"><strong>तयार गर्नेः</strong></p>
                                        <div class="pt-2 mb-2">
                                            <p class="mb-1"><strong>नामः</strong></p>
                                        </div>
                                        <div class="pt-2 mb-2">
                                            <p class="mb-1"><strong>पदः</strong></p>
                                        </div>
                                        <div class="pt-2">
                                            <p class="mb-0"><strong>मितिः</strong></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 text-center" style="min-height: 120px;">
                                        <p class="mb-2"><strong>प्रमाणित गर्नेः</strong></p>
                                        <div class="pt-2 mb-2">
                                            <p class="mb-1"><strong>नामः</strong></p>
                                        </div>
                                        <div class="pt-2 mb-2">
                                            <p class="mb-1"><strong>पदः</strong></p>
                                        </div>
                                        <div class="pt-2">
                                            <p class="mb-0"><strong>मितिः</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 ">
                            <p class="mb-1 p-3">
                                फाराम भर्ने तरिकाः <br>
                                १ एक कार्यालयको एकभन्दा बढी उपशीर्षकको बेरुजु भए एकपछि अर्को उपशीर्षकको बेरुजु देखिने
                                गरी लगत राख्ने गर्नुपर्दछ । <br>
                                २ विनियोजन, राजस्व र धरौटीको बेरुजुको अभिलेख राख्दा फरक फरक पाना नं. उल्लेख गरी अभिलेख
                                राख्नुपर्छ । <br>
                                ३ यस खाता प्रत्येक आर्थिक वर्षका लागि राखिन्छ । त्यसैले यस खाता कुन साल र कुन महिनाका
                                लागि यस खाता राखिएको हो सो साल र महिना लेख्नुपर्छ । <br>
                                ४ बेरुजुको विवरण बारम्बार प्रयोग हुने अवस्थामा छुट्टै सहायक खाता यही ढाँचामा तयार
                                गर्नुपर्नेछ जस्तै मोबिलाइजेसन पेस्की <br>
                                ५ आर्थिक वर्षमा चालु आर्थिक वर्ष लेख्नुपर्छ । <br>
                                ६ खाता पाना नं. मा प्रत्येक आर्थिक वर्षका लागि १ बाट सुरु गरी सिलसिलेबार रूपमा खाता पाना
                                नं. लेख्नुपर्छ । <br>
                                ७ बजेट उपशीर्षक/कारोबार नं. मा आर्थिक सङ्केत तथा वर्गीकरण र व्याख्यामा उल्लेख भएबमोजिमको
                                बजेट उपशीर्षक नं. लेख्नुपर्छ । <br>
                                ८ कायम बेरुजुको लगत कुन प्रकारको बेरुजु हो सो को प्रकृतिअनुसार विनियोजन, राजस्व, धरौटी
                                वा अन्य कोष मध्ये कुन हो सोको प्रकारमा कुनै एकमा ठिक चिह्न लगाउनुपर्छ र ठिक चिह्न जुन
                                प्रकारमा लगाइन्छ सोही प्रकारको अभिलेख राख्नुपर्ने हुन्छ । <br>
                                ९ महल १ मा सिलसिलेबार क्रम संख्या नं. लेख्नुपर्छ । <br>
                                १० महल २ मा लागुहुने आर्थिक बर्ष लेख्नुपर्छ । <br>
                                ११ महल ३ मा बेरुजु कायम भएको म.ले.प. प्रतिवेदनको दफा नं. लेख्नुपर्छ । <br>
                                १२ महल ४ मा बेरुजु कुन भौचर नं.बाट कायम हुन पुगेको हो सो भौचर नं. लेख्नुपर्छ । <br>
                                १३ महल ५ मा बेरुजुको संक्षिप्त व्यहोरा वा विवरण लेख्नुपर्छ । <br>
                                १४ महल ६ मा बेरुजुको बर्गीकरण निर्देशिकाबमोजिमको बेरुजुको उपबर्गीकरण लेख्नुपर्छ । <br>
                                १५ महल ७, ८ र ९ मा कायम भएको बेरुजुको प्रकार अनुसार क्रमशः नियमित गर्नुपर्ने बेरुजु,
                                पेस्की बेरुजु र असुल उपर गर्नुपर्ने बेरुजु रकम लेख्नुपर्छ । <br>
                                १६ महल १० मा महल ७ को नियमित गर्नुपर्ने बेरुजु, महल ८ को पेस्की बेरुजु र महल ९ को असुल
                                उपर गर्नुपर्ने बेरुजुको जोड जम्मा लेख्नुपर्छ । <br>
                                १७ महल ११, १२, १३ र १४ मा संपरीक्षण भएको बेरुजुको विवरण राख्नुपर्छ । यसमा क्रमशः
                                सम्परीक्षण मिति, सम्परीक्षण भएको नियमित गर्नुपर्ने बेरुजु, पेस्की बेरुजु र असुलउपर
                                गर्नुपर्ने बेरुजु रकम लेख्नुपर्छ । <br>
                                १८ महल १५ मा सम्परीक्षण भएको जोड जम्मा बेरुजु रकम लेख्नुपर्छ । <br>
                                १९ महल १६, १७, १८ र १९ मा सम्परीक्षण हुन बाँकी बेरुजु रकम लेख्नुपर्छ । यसमा क्रमशः
                                नियमित गर्नुपर्ने बेरुजु, पेस्की बेरुजु, असुल उपर गर्नुपर्ने बेरुजु र जोड जम्मा बाँकी
                                बेरुजु रकम लेख्नुपर्छ । <br>
                                २० महल २० मा कुनै कैफियत भएमा सो कैफियत उल्लेख गर्नुपर्छ । <br>
                                २१ जम्मा हरफमा रकमहरूको जोड जम्मा राख्नुपर्दछ । <br>
                                २२ बेरुजु अभिलेख तयार गर्ने तथा प्रमाणित गर्नेको नाम, पद र मिति लेखेर हस्ताक्षर
                                गर्नुपर्छ । <br>
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div class="container mt-4">
                    <div class="card mx-auto shadow d-flex align-items-center justify-content-center flex-column"
                        style="min-height: 200px;">
                        <h5 class="text-center">{{ __('beruju::beruju.no_data_to_show') }}</h5>
                    </div>
                </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('open-pdf-in-new-tab', (event) => {
                console.log(event);
                window.open(event.url, '_blank');
            });
        });

        // function printDiv() {
        //     const printContent = document.getElementById('print-content');
        //     if (!printContent) {
        //         alert("{{ __('beruju::beruju.no_content_for_print') }}");
        //         return;
        //     }

        //     const tableHTML = printContent.outerHTML;
        //     Livewire.dispatch('print-pdf', {
        //         tableHtml: tableHTML
        //     });
        // }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <style>
        #printContent {
            font-family: 'Noto Sans Devanagari', sans-serif;
            font-size: 7pt;
            padding: 10px;
            margin: 0;
            line-height: 1.1;
            width: 100%;
            max-width: 100%;
            overflow: visible;
        }

        #printContent table {
            font-family: 'Noto Sans Devanagari', sans-serif;
            font-size: 6pt !important;
            width: 100% !important;
            max-width: 100% !important;
            table-layout: fixed !important;
            border-collapse: collapse;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        #printContent th,
        #printContent td {
            font-family: 'Noto Sans Devanagari', sans-serif;
            font-size: 6pt !important;
            padding: 2px 3px !important;
            border: 1px solid #000;
            word-wrap: break-word;
            overflow-wrap: break-word;
            vertical-align: top;
            white-space: normal !important;
            box-sizing: border-box !important;
            text-align: center;
        }

        /* Balanced column widths for 21-column table */

        /* Force table visibility */
        #printContent table {
            display: table !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        #printContent tr {
            display: table-row !important;
            visibility: visible !important;
        }

        #printContent th,
        #printContent td {
            display: table-cell !important;
            visibility: visible !important;
            overflow: visible !important;
        }

        /* Override Bootstrap constraints */
        #printContent .container,
        #printContent .row,
        #printContent .col,
        #printContent .col-md-*,
        #printContent .col-lg-*,
        #printContent .col-xl-* {
            width: 100% !important;
            max-width: 100% !important;
            flex: none !important;
            margin: 0 !important;
            padding: 0 !important;
            box-sizing: border-box !important;
        }

        /* Remove table responsiveness */
        #printContent .table-responsive {
            overflow: visible !important;
            width: 100% !important;
        }
    </style>

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
