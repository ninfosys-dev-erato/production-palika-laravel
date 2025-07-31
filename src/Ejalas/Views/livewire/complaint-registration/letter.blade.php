<div>

    <div class="row g-3 mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="d-flex justify-content-end">
                    @perm('jms_judicial_management print')
                        <button class="btn btn-primary mt-2 me-2" onclick="printDiv()">Print</button>
                    @endperm
                </div>
                {{-- letter starts from here --}}
                <div id="printContent">
                    <div class="mx-4">
                        <div> {{-- complainer section --}}
                            @foreach ($complainers as $complainer)
                                {{ $complainer->permanentDistrict?->title }}
                                जिल्ला,{{ $complainer->permanentLocalBody?->title }} वडा नं
                                {{ $complainer->permanent_ward_id }}
                                {{ $complainer->permanent_tole }} बस्ने {{ $complainer->grandfather_name }}को
                                नाती/नातिनी,
                                {{ $complainer->father_name }}को छोरा/छोरी, {{ $complainer->spouse_name }}को
                                श्रीमान/श्रीमती,
                                वर्ष {{ $complainer->age }}को {{ $complainer->name }} निवेदक (प्रथम पक्ष) <br />
                            @endforeach
                        </div>
                        <h5 class="text-center font-bold">विरुद्ध</h5>
                        <div> {{-- defender section --}}
                            @foreach ($defenders as $defender)
                                {{ $complainer->permanentDistrict?->title }}
                                जिल्ला,{{ $complainer->permanentLocalBody?->title }} वडा नं
                                {{ $complainer->permanent_ward_id }}
                                {{ $complainer->permanent_tole }} बस्ने {{ $complainer->grandfather_name }}को
                                नाती/नातिनी,
                                {{ $complainer->father_name }}को छोरा/छोरी, {{ $complainer->spouse_name }}को
                                श्रीमान/श्रीमती,
                                वर्ष {{ $complainer->age }}को {{ $complainer->name }} विपक्षी (दोश्रो पक्ष) <br />
                            @endforeach
                        </div>
                        <div class="ms-5"> {{-- subject section --}}
                            विवाद/मुद्दा
                            :{{ $complaintRegistration->disputeMatter->disputeArea->title . ',' . $complaintRegistration->disputeMatter->title . ',' . $complaintRegistration->subject }}
                        </div>
                        <div> {{-- description section --}}
                            म निम्न बुदाँहरुमा लेखिए बमोजिम निवेदन गर्दछु ।
                            <div>
                                <p> १. संक्षिप्त विवरण: {{ $complaintRegistration->subject }}</p>
                                <p>२. यस समितिबाट दोस्रो पक्ष झिकाई जे जो वुझ्नुपर्छ वुझी विवाद निरुपण गराईपाउँ ।</p>

                                <p>३. यस नगरपालिकाबाट जारी भएको स्थानीय न्यायिक कार्यविधिको ........., वमोजिम निवेदन
                                    दस्तुर
                                    रु ......, दोस्रो पक्ष ...... जनालाई म्याद सूचना दस्तुर रु ........., पाना ...... को
                                    निवेदनको प्रतिलिपी दस्तुर रु ............. समेत गरी जम्मा रु ......यसै निवेदनसाथ
                                    दाखिल
                                    गरेको छु ।</p>

                                <p>४. यो निवेदन स्थानीय सरकार संचालन ऐन, २०७४ को दफा ४७ (१) अनुसार यसै समितिको अधिकार
                                    क्षेत्रभित्र पर्दछ ।</p>

                                <p>५. यो निवेदन हदम्यादभित्रै छ र म निवेदकलाई यस विषयमा निवेदन दिने हकदैया प्राप्त छ ।
                                </p>

                                <p>६. यस विषयमा अन्यत्र कहीँ कतै कुनै निकायमा कुनै प्रकारको निवेदन दिएको छैन ।</p>

                                <p>७. यसमा मेरो / हाम्रो निम्न साँक्षी बुझिपाऊँ ।</p>
                                <div class="ms-3">

                                    <p>(क) जिल्ला.........गाउँपालिका/नगरपालिका..........................वडा
                                        नं.......बस्ने
                                        ...........................वर्ष को................................</p>

                                    <p>(ख) जिल्ला.........गाउँपालिका/नगरपालिका..........................वडा
                                        नं.......बस्ने
                                        ...........................वर्ष को................................</p>

                                    <p>(ग) जिल्ला.........गाउँपालिका/नगरपालिका..........................वडा
                                        नं.......बस्ने
                                        ...........................वर्ष को................................</p>
                                </div>

                                <p>८. यसमा लेखिएका व्यहोरा ठिक साँचो सत्य हुन्, झुठा ठहरे कानून वमोजिम संजाय भोग्न तयार
                                    छु ।
                                </p>

                            </div>
                        </div>

                        <div> {{-- footer --}}
                            <div class="text-end">
                                <p>निवेदक</p>
                                <p>नाम :
                                    @foreach ($complainers as $key => $complainer)
                                        {{ $complainer->name }}@if ($key < $complainers->count() - 1)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                                <p>सही: ..................</p>
                                <p>सम्पर्क नं :
                                    @foreach ($complainers as $key => $complainer)
                                        {{ $complainer->phone_no }}@if ($key < $complainers->count() - 1)
                                            ,
                                        @endif
                                    @endforeach
                                </p>
                            </div>

                            <div class="text-center">

                                <p>{{ convertToNepaliDateFormat($complaintRegistration->reg_date_nepali) }}</p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printDiv() {
        const printContent = document.getElementById('printContent');
        if (!printContent) {
            alert('No content found for printing.');
            return;
        }
        @this.call('downloadPdf', printContent.innerHTML);
    }
</script>
