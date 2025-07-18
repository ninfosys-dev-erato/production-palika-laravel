@extends('home.layout')
@section('hero')
    <!-- Hero Section -->
    <div class="hero d-flex flex-column align-items-center justify-content-center">
        <h1 class="hero-heading">डिजिटल {{ getSetting('palika-name') }}</h1>
        <p class="hero-sub-heading">
            प्रविधिमुखी सार्वजनिक सेवा प्रवाहको सुनिश्चितताका लागि
        </p>
        <p class="hero-slug">
            सार्वजनिक सेवा प्रवाहमा प्रविधिको उच्चतम प्रयोग गर्दै सहज र चुस्त सेवा प्रदान गरी डिजिटल सेवाको दिशामा अगाडि
            बढ्ने प्रयास डिजिटल पालिका।
        </p>
        <div class="buttons">
            <button class="btn btn-primary">
                <a href="{{ route('digital-service') }}" class="text-white text-decoration-none">{{ __('Public Login') }}</a>
            </button>
            <button class="btn btn-success">
                <a href="{{ route('login') }}" class="text-white text-decoration-none">{{ __('Office Login') }}</a>
            </button>
            @if (isModuleEnabled('ebps'))
                <button class="btn btn-info">
                    <a href="{{ route('organization-login') }}"
                        class="text-white text-decoration-none">{{ __('EBPS-लगइन') }}</a>
                </button>
            @endif
        </div>
    </div>
@endsection


@section('content')
    <main>

        <x-employee-section-component />

        <!-- complaint-statistics-section -->
        @if (isModuleEnabled('grievance'))
            <section id="statistics" class="statistics-container">
                <div class="statistics-title-container">
                    <h2 class="statistics-title">गुनासो तथ्याङ्क</h2>
                    <p class="statistics-description">गुनासो तथ्याङ्क अनुभागले सेवाग्राहीहरूबाट प्राप्त गुनासोहरूको विवरण,
                        संख्या, र प्रगतिको अवस्थालाई प्रस्तुत गर्दछ। यो तथ्याङ्कले सेवाग्राहीको गुनासो व्यवस्थापन
                        प्रक्रियामा
                        पारदर्शिता
                        बढाउन र समस्याहरूलाई समाधान गर्न ध्यान केन्द्रित गरेको छ।</p>
                </div>

                <div class="statistics-wrapper">
                    <div class="statistics-card">
                        <div class="card-icon primary">
                            <div class="circle">
                                <span class="card-number" data-target="{{ $grievanceCount }}">0</span>
                            </div>
                        </div>
                        <div class="statistics-info">
                            <div class="card-label">कुल गुनासो</div>
                        </div>
                    </div>

                    <div class="statistics-card">
                        <div class="card-icon success">
                            <div class="circle">
                                <span class="card-number" data-target="{{ $grievancesClosedCount }}">0</span>
                            </div>
                        </div>
                        <div class="statistics-info">
                            <div class="card-label">पूर्ण गुनासो</div>
                        </div>
                    </div>

                    <div class="statistics-card">
                        <div class="card-icon pending">
                            <div class="circle">
                                <span class="card-number" data-target="{{ $grievancesInvestigatingCount }}">0</span>
                            </div>
                        </div>
                        <div class="statistics-info">
                            <div class="card-label">छानबिन गुनासो</div>
                        </div>
                    </div>
                </div>
            </section>
        @endif


        <!-- modules-section -->
        <section class="modules">
            <h2 class="module-title">डिजिटल {{ getSetting('palika-name') }} मोड्युल</h2>
            <div class="module-description">डिजिटल {{ getSetting('palika-name') }} प्रणालीमा प्रयोग भएका
                मोड्युलहरु को बिस्तृत जानकारी ।</div>


            @php
                $landingModules = [
                    [
                        'module' => 'digital_board',
                        'url' => route('digital-board.index'),
                        'icon' => 'home/icons/wadapatra.png',
                        'text' => 'डिजिटल नागरिक वडापत्र',
                    ],
                    [
                        'module' => 'recommendation',
                        'url' => route('digital-service'),
                        'icon' => 'home/icons/recomendation.png',
                        'text' => 'सिफारिस',
                    ],
                    [
                        'module' => 'grievance',
                        'url' => route('customer.home.grievance-list'),
                        'icon' => 'home/icons/complaint.png',
                        'text' => 'गुनासो पोर्टल',
                    ],
                    [
                        'module' => 'ebps',
                        'url' => route('digital-service'),
                        'icon' => 'home/icons/ebps.png',
                        'text' => 'EBPS प्रणाली',
                    ],
                    [
                        'module' => 'business_registration',
                        'url' => route('digital-service'),
                        'icon' => 'home/icons/business.png',
                        'text' => 'व्यवसाय दर्ता',
                    ],
                ];
            @endphp

            <div class="module-grid">
                @foreach ($landingModules as $module)
                    @if (isModuleEnabled($module['module']))
                        <div class="module-card">
                            <a href="{{ $module['url'] }}" target="_blank">
                                <img src="{{ asset($module['icon']) }}" alt="{{ $module['text'] }} Icon" />
                                <div class="module-text">{{ $module['text'] }}</div>
                            </a>
                        </div>
                    @endif
                @endforeach

                <div class="module-card">
                    <a href="https://sutrarevenue.fcgo.gov.np/web/#/login" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="Training Icon" />
                        <div class="module-text">राजस्व पोर्टल</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://newpams.fcgo.gov.np/#/Login" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="PAMS Icon" />
                        <div class="module-text">PAMS जिन्सि ब्यबस्थापन</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://sutra.fcgo.gov.np/" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="SuTRA Icon" />
                        <div class="module-text">SuTRA</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://public.donidcr.gov.np/" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="Digitalcart Icon" />
                        <div class="module-text">अनलाईन घटना दर्ता (निवेदन)</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://enrollment.donidcr.gov.np/PreEnrollment/" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="ID Card Icon" />
                        <div class="module-text">राष्ट्रिय परिचयपत्रको अनलाईन आबेदन</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://attendance.gov.np/" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="Attendance Icon" />
                        <div class="module-text">एकिकृत हाजिरी व्यबस्थापन प्रणाली</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://bolpatra.gov.np/egp/" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="Profile Icon" />
                        <div class="module-text">बोलपत्र आवहन प्रणाली</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://lisa.mofaga.gov.np/home" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="Planmanagement Icon" />
                        <div class="module-text">स्थानीय तह संस्थागत क्षमता स्वमूल्याङ्कन (LISA)</div>
                    </a>
                </div>

                <div class="module-card">
                    <a href="https://fra.mofaga.gov.np/" target="_blank">
                        <img src="{{ asset('home/icons/sarkar.png') }}" alt="Financial Risk Icon" />
                        <div class="module-text">स्थानीय तह वित्तीय सुशासन जोखिम मूल्याङ्कन</div>
                    </a>
                </div>


            </div>
        </section>



        <!-- features-section -->
        <section class="features">
            <h2>विशेषताहरू</h2>
            <p class="feature-description">डिजिटल {{ getSetting('palika-name') }} प्रणालीमा प्रयोग भएका
                मोड्युलहरु को बिस्तृत जानकारी ।
            </p>

            <div class="list-features">
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>राष्ट्रिय डेटा पहुँच</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>एकीकृत मोबाइल र वेबमा आधारित प्रणाली</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>व्यक्तिगत, व्यवसाय र संस्थागत जानकारी</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>पालिकाको दैनिक गतिविधिहरुमा नागरिकको सक्रिय संलग्नता</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>सेवाग्राहीलाई अडियो, भिडियो मार्फत जानकारी</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>पालिकाको दैनिक कार्यसम्पादन गर्न सहयोग</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>नागरिकका सेवा र जानकारीको अनलाइनमा पहुँच</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>पालिकाले प्रवाह गर्ने सेवाहरुलाई अनलाइन मार्फत आवेदन लिने, दर्ता गर्ने र प्रमाणपत्र प्रदान</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>पालिकाको जनप्रतिनिधि, कर्मचारी र सेवाग्राहीको समयको बचत</p>
                </div>
                <div class="indv-features">
                    <img src="https://cdn-icons-png.flaticon.com/512/5709/5709755.png" alt="">
                    <p>पालिकालाई एकीकृत सफ्टवेयरमा आवद्ध गरि सुचना, तथ्यांक, सेवाप्रवाहमा सहज</p>
                </div>
            </div>

            <div class="more">
                <button class="btn btn-primary">
                    <a href="#" class="text-white text-decoration-none">थप हेर्नुहोस्</a>
                </button>
            </div>


        </section>

        <section class="extra-info">
            <div class="container text-center">
                <h2 class="extra-info__title">थप जानकारी</h2>
                <p class="extra-info__description">
                    यहाँ तपाईंले हाम्रो वेबसाइट र प्रदान गरिएका सेवाहरूको बारेमा विस्तृत जानकारी पाउन सक्नुहुन्छ।
                    हामी तपाईंलाई उत्कृष्ट अनुभव प्रदान गर्न प्रतिबद्ध छौं।
                </p>

                <div class="extra-info__cards">
                    <!-- Services Card -->
                    <div class="extra-info__card">
                        <h3 class="extra-info__card-title">सेवाहरू</h3>
                        <p class="extra-info__card-text">
                            हामी विभिन्न प्रकारका सेवाहरू प्रदान गर्दछौं, जसले तपाईंको आवश्यकता पूरा गर्न सहयोग पुर्‍याउँछ।
                        </p>
                        <a href="#" class="extra-info__link" data-bs-toggle="modal"
                            data-bs-target=".modal-services">
                            थप जान्नुहोस्
                        </a>
                    </div>

                    <!-- Contact Card -->
                    <div class="extra-info__card">
                        <h3 class="extra-info__card-title">सम्पर्क जानकारी</h3>
                        <p class="extra-info__card-text">
                            हामीलाई प्रत्यक्ष सम्पर्क गर्न सक्नुहुन्छ। हाम्रो ग्राहक सेवा टीम सधैं उपलब्ध छ।
                        </p>
                        <a href="#" class="extra-info__link" data-bs-toggle="modal"
                            data-bs-target=".modal-contact">
                            थप जान्नुहोस्
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Modal Templates -->
        <div class="modal fade modal-services" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">सेवाहरूको जानकारी</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">{!! $services !!}</div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade modal-contact" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">सम्पर्क जानकारी</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p>सम्पर्क जानकारीका लागि कृपया तलका विवरणहरू प्रयोग गर्नुहोस्:</p>
                        <ul class="list-unstyled">
                            <li><strong>सम्पर्क नं:</strong> <a href="tel:{{ getSetting('office_phone') }}"
                                    class="extra-info__contact-link">{{ getSetting('office_phone') }}</a></li>
                            <li><strong>ईमेल:</strong> <a href="mailto:{{ getSetting('office_email') }}"
                                    class="extra-info__contact-link">{{ getSetting('office_email') }}</a></li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </main>


    {{-- script to animate numbers in gunaso section  --}}
    <script>
        // Function to animate the numbers
        document.addEventListener('DOMContentLoaded', function() {
            const numbers = document.querySelectorAll('.card-number');

            numbers.forEach(number => {
                const target = +number.getAttribute('data-target');
                let count = 0;

                function updateNumber() {
                    const increment = target / 100;
                    count += increment;
                    if (count >= target) {
                        number.textContent = target;
                    } else {
                        number.textContent = Math.ceil(count);
                        requestAnimationFrame(updateNumber);
                    }
                }

                updateNumber();
            });
        });
    </script>
@endsection
