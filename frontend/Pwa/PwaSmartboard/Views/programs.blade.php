<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getSetting('palika-name') }} Smartboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/nepali-date-converter@3.3.4/dist/nepali-date-converter.umd.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        :root {
            --primary: #264F8B;
            --secondary: #2460B9;
            --text-primary: #FFFFFF;
            --text-secondary: #EDEDED;
            --table-row: #F5F5F5;
            --border: #D9D9D9;
        }

        body {
            max-width: 100vw;
            max-height: 100vh;
            box-sizing: border-box;
            overflow: hidden;
        }

        @keyframes scrollUp {
            0% {
                transform: translateY(0%);
            }

            100% {
                transform: translateY(-50%);
            }
        }

        .scroll-content {
            animation: scrollUp linear infinite;
            animation-duration: calc({{ count($citizenharters) }} * 10s);
        }

        .scroll-content:hover {
            animation-play-state: paused;
        }

        #citizenCharterContainer {
            overflow: hidden;
        }

        #citizenCharterScroll {
            transition: all 1s ease-in-out;
        }

        /* The scroll keyframes definition remains the same */
        @keyframes scroll {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        /* Base Styles */
        .profile-carousel {
            position: relative;
            overflow: hidden;
            padding: 1rem 0;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
            will-change: transform;
        }

        .profile-card {
            flex: 0 0 calc(50% - 1rem);
            margin: 0 0.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 15vh;
        }

        .profile-image-container {
            height: 70%;
            overflow: hidden;
            position: relative;
        }

        .profile-image {
            width: fit-content;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .profile-name {
            font-size: 0.9rem;
            font-weight: 600;
            margin-top: 0.3rem;
            color: rgb(22, 22, 22)
        }

        .profile-designation {
            font-size: 0.6rem;
            color: #666;
        }

        /* Animation Styles */
        @keyframes slide {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }


        .slide-track {
            display: flex;
            animation: scroll-notices linear infinite;
        }

        @keyframes scroll-notices {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }
    </style>
</head>

<body>
    <div>

        {{-- header section --}}
        <header style="height: 12vh; background: var(--primary); color: var(--text-primary);">
            <div class="d-flex justify-content-between align-items-center container-fluid"
                style="background-color: var(--secondary); height: 3vh;">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        style="fill: rgb(236, 236, 236);transform: ;msFilter:;">
                        <path
                            d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm3.293 14.707L11 12.414V6h2v5.586l3.707 3.707-1.414 1.414z">
                        </path>
                    </svg>
                    <div class="text-white font-monospace ms-1" style="font-size: 0.6rem" id="current-time">Loading....
                    </div>
                </div>

                <p class="m-0 text-center" style="font-size: 0.6rem;">
                    संस्कृति, सम्पदा र प्रविधिको समुचित विकाससहित हरित, स्वच्छ र समृद्ध नगर निर्माणतर्फ हाम्रो
                    प्रतिबद्धता।
                </p>
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        style="fill: rgb(236, 236, 236);transform: ;msFilter:;">
                        <path
                            d="M21 20V6c0-1.103-.897-2-2-2h-2V2h-2v2H9V2H7v2H5c-1.103 0-2 .897-2 2v14c0 1.103.897 2 2 2h14c1.103 0 2-.897 2-2zM9 18H7v-2h2v2zm0-4H7v-2h2v2zm4 4h-2v-2h2v2zm0-4h-2v-2h2v2zm4 4h-2v-2h2v2zm0-4h-2v-2h2v2zm2-5H5V7h14v2z">
                        </path>
                    </svg>
                    <div class="text-white ms-1" style="font-size: 0.6rem" id="current-date">Loading...</div>
                </div>
            </div>
            <div class="container-fluid d-flex align-items-center justify-content-between " style="height: 9vh">
                <img src="{{ getSetting('palika-logo') }}" alt="Logo" height="50" width="50">
                <div class="text-center ms-5">
                    <h3 class="fw-bold mb-1" style="font-size: 1rem;">{{ getSetting('palika-name') }}</h3>
                    <h4 class="fw-bold mb-1" style="font-size: 0.7rem;">{{ getSetting('office-name') }}</h4>
                    <h5 class="fw-semibold" style="font-size: 0.6rem;">
                        {{ getSetting('palika-province') . ', ' . getSetting('palika-district') . ', ' . 'नेपाल्' }}
                    </h5>
                </div>
                <div class="d-flex align-items-center">
                    <img src="{{ getSetting('palika-campaign-logo') }}" alt="Campaign Logo" height="50" width="50">
                    <div class="ms-1 " style="font-size: 0.6rem; color: rgba(255, 255, 255, 0.822);">
                        <div>{{ getSetting('office_phone') }}</div>
                        <div>{{ getSetting('office_email') }}</div>
                        <p class="m-0">समृद्ध चन्दननाथ नगरपालिका, सभ्य समाज</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- main section --}}
        <main style="height: 80vh">
            <div class="d-flex container-fluid" style="height: 100%">
                <div class="h-100" style="width: 75%;">
                    <livewire:pwa.pwa_smartboard.programs :ward="$ward" />
                </div>
                {{-- citizen-charter section --}}
                <div class="h-100 px-2 py-3 ms-3" style="width: 25%">
                    <h2 class="fs-5 fw-bold">नागरिक वडापत्र</h2>
                    <div id="citizenCharterContainer" class="position-relative" style="height: 95%" ; overflow:
                        hidden;">
                        <div id="citizenCharterScroll" class="scroll-content d-flex flex-column pe-1" wire:poll.5s>
                            @foreach($citizenharters as $citizenharter)
                                <div class="bg-light p-2 px-3 mt-1  d-flex flex-column rounded-2 shadow"
                                    wire:key="citizenharter-{{ $citizenharter->id }}">
                                    <h2 class="" style="font-size: 1rem; color: var(--primary);">{{$citizenharter->service}}
                                    </h2>
                                    <div class="d-flex align-items-center">
                                        <p class="m-0 text-secondary" style="font-size: 0.8rem">शुल्क:</p>
                                        <span class="ms-2" style="font-size: 0.8rem">{{$citizenharter->amount}}</span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="m-0 text-secondary" style="font-size: 0.8rem">लाग्ने समय:</p>
                                        <span class="ms-2" style="font-size: 0.8rem">{{$citizenharter->time}}</span>
                                    </div>
                                    <div>
                                        <p class="m-0 text-secondary" style="font-size: 0.8rem">आवश्यक कागजातहरू:</p>
                                        <span class="text-dark" style="font-size: 0.8rem">
                                            {!! nl2br(e($citizenharter->required_document)) !!}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </main>


        {{-- notices section --}}
        <section class="d-flex align-items-center px-2"
            style="height: 5vh; background: var(--secondary); color: var(--text-primary);">
            <div class="d-flex align-items-center" style="margin-right: 0.4rem">
                <div class="bg-white"
                    style="width: fit-content; padding: 0.25rem 0.75rem; border-radius: 0 1rem 0 1rem;">
                    <p class="fw-semibold m-0" style="color: var(--primary); font-size: 1rem;">सूचना</p>
                </div>
            </div>
            <div class="slider w-100 overflow-hidden position-relative">
                <div class="slide-track d-flex" style="white-space: nowrap; position: relative; right: 0;"
                    id="notices-track">
                    @foreach($notices as $notice)
                        <p class="mb-0 mx-3 text-nowrap" style="font-size: 0.7rem; color: var(--text-secondary)"
                            wire:key="notice-{{ $notice->id }}">
                            {{ $notice->title }}
                        </p>
                    @endforeach
                    {{-- Clone the notices to create a seamless loop --}}
                    @foreach($notices as $notice)
                        <p class="mb-0 mx-3 text-nowrap" style="font-size: 0.7rem; color: var(--text-secondary)">
                            {{ $notice->title }}
                        </p>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- footer section --}}
        <footer style="height: 3vh; background: var(--primary); color: var(--text-primary);">
            <div class="text-center text-light py-2">
                <p class="mb-0" style="font-size: 0.7rem;">{{ date('Y') }} © Design and Developed by Ninja Infosys
                </p>
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const dateElement = document.getElementById("current-date");
            const timeElement = document.getElementById("current-time");

            const updateDateTime = () => {
                const now = new Date();
                const nepaliDate = new NepaliDate(now);
                const formattedNepaliDate = nepaliDate.format("DD MMMM YYYY ddd", "np");
                const nepaliTime = new Intl.DateTimeFormat("ne-NP", {
                    timeStyle: "medium",
                    numberingSystem: "deva",
                    hour12: false,
                }).format(now);

                dateElement.textContent = formattedNepaliDate;
                timeElement.textContent = nepaliTime;
            };

            updateDateTime();
            const interval = setInterval(updateDateTime, 1000);
            window.addEventListener("beforeunload", () => clearInterval(interval));

            const scrollContent = document.querySelector('.scroll-content');
            const container = document.getElementById('citizenCharterContainer');

            // Calculate dynamic animation duration based on content
            const itemCount = {{ count($citizenharters) }};
            const duration = itemCount * 10; // 10 seconds per item
            scrollContent.style.animationDuration = `${duration}s`;

            // Pause animation on hover
            container.addEventListener('mouseenter', () => {
                scrollContent.style.animationPlayState = 'paused';
            });

            container.addEventListener('mouseleave', () => {
                scrollContent.style.animationPlayState = 'running';
            });


            class Carousel {
                constructor(selector, items, interval = 3000) {
                    this.container = document.querySelector(selector);
                    if (!this.container) return;

                    this.track = this.container.querySelector('.carousel-track');
                    this.items = items;
                    this.itemCount = items.length;
                    this.currentIndex = 0;
                    this.interval = interval;
                    this.animation = null;
                    this.isPaused = false;

                    this.init();
                    this.startAutoSlide();
                    this.addEventListeners();
                }

                init() {
                    if (this.itemCount > 1) {
                        // Clone first 2 items for seamless looping
                        const clones = Array.from(this.track.children)
                            .slice(0, 2)
                            .map(el => el.cloneNode(true));
                        clones.forEach(clone => this.track.appendChild(clone));
                    }
                }

                updateSlide() {
                    if (this.itemCount <= 1) return;

                    this.currentIndex = (this.currentIndex + 1) % this.itemCount;
                    const translateX = -this.currentIndex * 50;
                    this.track.style.transform = `translateX(${translateX}%)`;

                    // Reset position when reaching cloned items
                    if (this.currentIndex === this.itemCount) {
                        setTimeout(() => {
                            this.track.style.transition = 'none';
                            this.currentIndex = 0;
                            this.track.style.transform = 'translateX(0)';
                            setTimeout(() => {
                                this.track.style.transition = 'transform 0.5s ease-in-out';
                            }, 10);
                        }, 500);
                    }
                }

                startAutoSlide() {
                    if (this.itemCount <= 1) return;

                    this.animation = setInterval(() => {
                        if (!this.isPaused) this.updateSlide();
                    }, this.interval);
                }

                addEventListeners() {
                    // Pause on hover
                    this.container.addEventListener('mouseenter', () => {
                        this.isPaused = true;
                    });

                    this.container.addEventListener('mouseleave', () => {
                        this.isPaused = false;
                    });

                    // Handle window resize
                    let resizeTimeout;
                    window.addEventListener('resize', () => {
                        clearTimeout(resizeTimeout);
                        resizeTimeout = setTimeout(() => {
                            this.track.style.transition = 'none';
                            this.track.style.transform = `translateX(-${this.currentIndex * 50}%)`;
                            setTimeout(() => {
                                this.track.style.transition = 'transform 0.5s ease-in-out';
                            }, 10);
                        }, 100);
                    });
                }
            }

            const noticesTrack = document.getElementById("notices-track");
            const noticesCount = {{ count($notices) }};
            const animationDuration = noticesCount * 25; // Increased to 10 seconds per notice for slower animation

            // Set the animation duration dynamically
            if (noticesTrack) {
                noticesTrack.style.animationDuration = `${animationDuration}s`;
            }

            const redirectTimeout = 300000; // 5 minutes
            setTimeout(() => {
                window.location.href = "{{ route('smartboard.index') }}"; // Replace with the route to your index page
            }, redirectTimeout);

        });

        // Initialize Lucide icons
        lucide.createIcons();
    </script>

</body>

</html>