<div style="height: 89vh">
    <section class="d-flex align-items-center px-2"
        style="height: 4vh; background: var(--secondary); color: var(--text-primary);">
        <div class="d-flex align-items-center">
            <p class="mb-0 me-3" style="font-size: 0.8rem;">सूचना</p>
            <p class="mb-0">|</p>
        </div>
        <div class="slider w-100 overflow-hidden">
            <div class="slide-track d-flex">
                @foreach (array_merge($notices->toArray(), $notices->toArray()) as $notice)
                    <p class="mb-0 mx-3 text-nowrap" style="font-size: 0.7rem; color: var(--text-secondary)">
                        {{ $notice['title'] }}
                    </p>
                @endforeach
            </div>
        </div>
    </section>

    <section class="d-flex gap-2 px-1 py-2" style="height: 85vh;">
        <!-- Citizen Charter -->
        <div class="border border-border flex-grow-1 p-3"
            style="height: 100%; width: 70%; position: relative; overflow: hidden;">
            <h3 class="mb-2 sticky-top bg-white fw-bold fs-4">नागरिक वडापत्र</h3>
            <table class="table">
                <thead class="text-center table-primary sticky-top">
                    <tr>
                        <th style="width: 3%; text-align: left; font-size: 1rem;">क्र.सं.</th>
                        <th style="width: 15%; text-align: left; font-size: 1rem;">सेवा</th>
                        <th style="width: 40%; text-align: left; font-size: 1rem;">आवश्यक कागजातहरु</th>
                        <th style="width: 19%; text-align: left; font-size: 1rem;">सेवा शुल्क</th>
                        <th style="width: 28%; text-align: left; font-size: 1rem;">लाग्ने समय</th>
                    </tr>
                </thead>
            </table>

            <div id="citizenCharterScroll" class="table-responsive" style="max-height: calc(85vh - 80px);">
                <table class="table">
                    <tbody>
                        @foreach ($citizenharters as $index => $citizenharter)
                            <tr class="align-middle" style="color: var(--text-primary)">
                                <td class="text-center"
                                    style="color: rgba(0, 0, 0, 0.788); width: 3%; font-size: 1rem;">
                                    {{ str_replace(['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], ['०', '१', '२', '३', '४', '५', '६', '७', '८', '९'], $index + 1) }}
                                </td>
                                <td class="align-middle"
                                    style="color: rgba(0, 0, 0, 0.788); width: 15%; font-size: 1rem;">
                                    {{ $citizenharter->service }}
                                </td>
                                <td class="align-middle"
                                    style="color: rgba(0, 0, 0, 0.788); width: 40%; font-size: 1rem;">
                                    {!! nl2br(e($citizenharter->required_document)) !!}
                                </td>
                                <td class="align-middle"
                                    style="color: rgba(0, 0, 0, 0.788); width: 19%; font-size: 1rem;">
                                    {{ $citizenharter->amount }}
                                </td>
                                <td class="align-middle"
                                    style="color: rgba(0, 0, 0, 0.788); width: 28%; font-size: 1rem;">
                                    {{ $citizenharter->time }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex flex-column" style="width: 30%; height: 83vh; overflow: hidden">
            <div class="border border-border p-2 mb-2 rounded" style="height: 25vh;">
                <div id="videoCarousel" class="carousel slide h-100" data-bs-ride="false">
                    <div class="carousel-inner h-100">
                        @foreach ($videos as $index => $video)
                            <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}"
                                data-video-index="{{ $index }}">
                                @if ($video->file)
                                    <!-- Local video code remains the same -->
                                @elseif ($video->url)
                                    @php
                                        $urlParts = parse_url($video->url);
                                        parse_str($urlParts['query'] ?? '', $params);
                                        $videoId = $params['v'] ?? pathinfo($urlParts['path'] ?? '', PATHINFO_BASENAME);
                                    @endphp
                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1&mute=1"
                                        frameborder="0" class="w-100 h-100"
                                        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                                        allowfullscreen loading="lazy"></iframe>
                                @else
                                    <p>No video available.</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- Programs Carousel -->
            <div class="border border-border mb-2 rounded" style="height: 28vh;">
                <div class="text-white px-2 py-1 text-center" style="background: var(--secondary);">
                    <h6 class="mb-0">कार्यक्रमहरू</h6>
                </div>
                <div class="position-relative" style="height: calc(100% - 30px);">
                    <!-- Program Content -->
                    <div id="programsCarousel" class="carousel slide h-100" data-bs-ride="carousel"
                        data-bs-interval="5000">
                        <div class="carousel-inner h-100">
                            @foreach ($programs as $index => $program)
                                <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }} position-relative">
                                    <div class="h-100 d-flex flex-column">
                                        <div class="flex-grow-1 d-flex align-items-center justify-content-center p-2">
                                            <img src="{{ customFileAsset(config('src.DigitalBoard.program.photo_path'), $program->photo, 'local', 'tempUrl') }}"
                                                alt="{{ $program->title }}" class="d-block w-100"
                                                style="height: 100%; max-width: 100%; object-fit: contain;">
                                        </div>
                                        <!-- Title -->
                                        <div class="program-title-wrapper position-absolute start-50 translate-middle-x bottom-0 w-100 p-1 text-center"
                                            style="background: rgba(0, 0, 0, 0.55);">
                                            <p class="mb-0 program-title fw-semibold text-white">
                                                {{ $program->title }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Combined Employee/Representative Section -->
            <div class="border border-border rounded" style="height: 35vh;">
                <div class="employee-container d-flex align-items-center"
                    style="height: calc(100% - 10px); width: 100%; overflow: hidden; border: 1px solid #EEE">
                    <!-- Representatives Section -->
                    <div class="h-100" style="width: 35%; overflow: hidden;">
                        <div class="text-white px-2 py-1 text-center" style="background: var(--secondary);">
                            <h6 class="mb-0">जनप्रतिनिधिहरू</h6>
                        </div>
                        <div class="profile-carousel representative-carousel h-100">
                            <div class="carousel-track h-100 align-items-center d-flex">
                                @foreach ($representatives as $rep)
                                    <div class="profile-card profile-card-single pb-1"
                                        wire:key="representative-{{ $rep->id }}" style="height: 90%">
                                        <div class="profile-image-container d-flex w-100 justify-content-center">
                                            <img src="{{ customFileAsset(config('src.Employees.employee.photo_path'), $rep->photo, 'local', 'tempUrl') }}"
                                                class="profile-image h-100 w-auto">
                                        </div>
                                        <div class="w-100 text-center mt-2">
                                            <h3 class="profile-name m-0">{{ $rep->name ?? 'N/A' }}</h3>
                                            <p class="profile-designation m-0">
                                                {{ $rep->designation->title ?? 'No Designation' }}
                                            </p>
                                            <p class="profile-designation m-0">
                                                {{ $rep->phone ?? 'No Number' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Employees Section -->
                    <div class="h-100" style="width: 65%; overflow: hidden; border: 1px solid #EEE">
                        <div class="text-white px-2 py-1 text-center" style="background: var(--secondary);">
                            <h6 class="mb-0">कर्मचारीहरू</h6>
                        </div>
                        <div class="profile-carousel employee-carousel h-100 ">
                            <div class="carousel-track h-100 align-items-center">
                                @foreach ($employees as $emp)
                                    <div class="profile-card pb-1" wire:key="employee-{{ $emp->id }} "
                                        style="height: 90%">
                                        <div class="profile-image-container d-flex w-100 justify-content-center">
                                            <img src="{{ customFileAsset(config('src.Employees.employee.photo_path'), $emp->photo, 'local', 'tempUrl') }}"
                                                class="profile-image h-100 w-auto">
                                        </div>
                                        <div class="w-100 text-center mt-2">
                                            <h3 class="profile-name m-0">{{ $emp->name }}</h3>
                                            <p class="profile-designation m-0">
                                                {{ $emp->designation->title ?? 'No Designation' }}
                                            </p>
                                            <p class="profile-designation m-0">
                                                {{ $rep->phone ?? 'No Number' }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <style>
        .profile-carousel {
            position: relative;
            overflow: hidden;
            padding: 1rem 0;
        }

        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-in-out;
            /* Decreased to 0.5s */
        }

        .profile-card {
            flex: 0 0 calc(50% - 1rem);
            margin: 0 0.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            height: 20vh;
        }

        .profile-card-single {
            flex: 0 0 100% !important;
            /* Override the default 50% width for representatives */
            margin: 0 auto !important;
            width: 90% !important;
        }

        .profile-image-container {
            height: 65%;
            overflow: hidden;
            position: relative;
        }

        .profile-image {
            width: fit-content;
            height: 100%;
        }

        .profile-name {
            font-size: 0.7rem;
            font-weight: 600;
            margin-top: 0.5rem;
            color: rgb(22, 22, 22)
        }

        .profile-designation {
            font-size: 0.6rem;
            color: #666;
        }

        /* Add to your existing styles */
        .carousel-control-prev,
        .carousel-control-next {
            display: none;
        }

        .youtube-player {
            background: #000;
        }

        /* Find and replace the existing .slide-track style with this */
        .slide-track {
            animation: scroll 100s linear infinite;
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


        /* Table responsiveness */
        .table-responsive {
            max-height: calc(85vh - 80px);
        }

        /* Program title */
        .program-title {
            font-size: 14px;
            line-height: 1.2;
            max-height: 34px;
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            text-overflow: ellipsis;
        }

        /* Sticky header */
        .sticky-top {
            position: sticky;
            top: 0;
            z-index: 1020;
        }


        /* Hide scrollbar for Chrome, Safari, and Opera */
        tbody::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge, and Firefox */
        tbody {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        /* Auto-scroll animation */
        @keyframes autoScroll {
            0% {
                transform: translateY(0%);
            }

            100% {
                transform: translateY(-100%);
            }
        }

        /* Hide scrollbar for Citizen Charter table */
        #citizenCharterScroll {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
            overflow: hidden;
            /* Prevent scrollbar visibility */
        }

        #citizenCharterScroll::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        /* Responsive font sizes for Citizen Charter table */
        @media (max-width: 768px) {

            table th,
            table td {
                font-size: 0.8rem;
                /* Smaller font size for smaller screens */
                padding: 0.5rem;
                /* Adjust padding */
            }
        }

        @media (max-width: 576px) {

            table th,
            table td {
                font-size: 0.7rem;
                /* Further reduce font size for very small screens */
                padding: 0.4rem;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            class Carousel {
                constructor(selector, isRepresentative = false) {
                    this.container = document.querySelector(selector);
                    this.track = this.container.querySelector('.carousel-track');
                    this.items = Array.from(this.track.children);
                    this.isRepresentative = isRepresentative;

                    // Clone items based on type
                    if (isRepresentative) {
                        // For representatives - clone only one item
                        const firstItem = this.items[0].cloneNode(true);
                        this.track.appendChild(firstItem);
                        this.slideWidth = 100; // 100% width for representatives
                    } else {
                        // For employees - clone first two items
                        const firstTwo = this.items.slice(0, 2).map(item => item.cloneNode(true));
                        firstTwo.forEach(item => this.track.appendChild(item));
                        this.slideWidth = 50; // 50% width for employees
                    }

                    this.position = 0;
                    this.totalItems = this.items.length;
                    this.startSlideshow();
                }
                slide() {
                    this.position++;
                    const translateX = -(this.position * this.slideWidth);
                    this.track.style.transform = `translateX(${translateX}%)`;

                    // Reset to beginning when reaching cloned items
                    if (this.position >= this.totalItems) {
                        setTimeout(() => {
                            this.track.style.transition = 'none';
                            this.position = 0;
                            this.track.style.transform = 'translateX(0)';
                            setTimeout(() => {
                                this.track.style.transition = 'transform 0.5s ease-in-out';
                            }, 20);
                        }, 500);
                    }
                }

                startSlideshow() {
                    setInterval(() => this.slide(), 3000); // Decreased to 3 seconds
                }
            }

            class ProgramSlider {
                constructor() {
                    this.container = document.querySelector('.program-slider');
                    if (!this.container) return;

                    this.track = this.container.querySelector('.program-track');
                    this.items = Array.from(this.track.children);
                    if (this.items.length <= 1) return;

                    // Clone first item and append to end
                    const firstSlide = this.items[0].cloneNode(true);
                    this.track.appendChild(firstSlide);

                    this.position = 0;
                    this.totalItems = this.items.length;
                    this.isAnimating = false;

                    this.startSlideshow();
                }

                slide() {
                    if (this.isAnimating) return;
                    this.isAnimating = true;

                    this.position++;
                    this.track.style.transform = `translateX(-${this.position * 100}%)`;

                    if (this.position >= this.totalItems) {
                        setTimeout(() => {
                            this.track.style.transition = 'none';
                            this.position = 0;
                            this.track.style.transform = 'translateX(0)';
                            setTimeout(() => {
                                this.track.style.transition = 'transform 0.8s ease-in-out';
                                this.isAnimating = false;
                            }, 50);
                        }, 800);
                    } else {
                        setTimeout(() => {
                            this.isAnimating = false;
                        }, 800);
                    }
                }

                startSlideshow() {
                    setInterval(() => {
                        if (!this.isAnimating) {
                            this.slide();
                        }
                    }, 7000);
                }
            }

            // Initialize carousels and program slider
            new Carousel('.representative-carousel', true); // true for representative carousel
            new Carousel('.employee-carousel', false); // false for employee carousel


            // Auto-scroll for Citizen Charter
            const citizenCharterScroll = document.getElementById('citizenCharterScroll');
            const citizenCharterTableBody = citizenCharterScroll.querySelector('tbody');
            let scrollSpeed = 0.2; // Further reduced speed for even slower scrolling
            let scrollPosition = 0;

            // Duplicate Citizen Charter rows for seamless scrolling
            function duplicateCitizenCharterRows() {
                const rows = Array.from(citizenCharterTableBody.children);
                rows.forEach(row => {
                    const clone = row.cloneNode(true);
                    citizenCharterTableBody.appendChild(clone);
                });
            }

            // JavaScript-based scrolling for better WebView compatibility
            function startAutoScroll() {
                function scrollStep() {
                    scrollPosition += scrollSpeed;
                    if (scrollPosition >= citizenCharterTableBody.scrollHeight / 2) {
                        scrollPosition = 0; // Reset scroll position for seamless loop
                    }
                    citizenCharterScroll.scrollTop = scrollPosition;
                    requestAnimationFrame(scrollStep); // Use requestAnimationFrame for smooth scrolling
                }
                scrollStep();
            }

            // Initialize duplication and scrolling
            duplicateCitizenCharterRows();
            startAutoScroll();



            const videoCarousel = new bootstrap.Carousel(document.getElementById('videoCarousel'), {
                interval: false,
                wrap: true
            });

            // Handle local video end
            function handleVideoEnd() {
                videoCarousel.next();
            }

            // Initialize first video or iframe autoplay
            const firstActiveItem = document.querySelector('.carousel-item.active');
            if (firstActiveItem) {
                const videoElement = firstActiveItem.querySelector('video');
                const iframeElement = firstActiveItem.querySelector('iframe');

                if (videoElement) {
                    videoElement.play().catch(error => {
                        console.error('Autoplay failed for video:', error);
                        videoCarousel.next();
                    });
                } else if (iframeElement) {
                    // Iframe autoplay is handled via the `autoplay=1` parameter in the iframe URL
                    console.log('Iframe autoplay initialized.');
                }
            }

            // Handle carousel slide events
            document.getElementById('videoCarousel').addEventListener('slid.bs.carousel', function(event) {
                const activeIndex = event.to;
                const activeItem = document.querySelectorAll('.carousel-item')[activeIndex];

                // Pause all videos
                document.querySelectorAll('video').forEach(video => video.pause());

                // Play current item
                if (activeItem.querySelector('video')) {
                    const video = activeItem.querySelector('video');
                    video.currentTime = 0;
                    video.play().catch(error => {
                        console.error('Autoplay failed for video:', error);
                        videoCarousel.next();
                    });
                }
            });
            // Error handling for local videos
            document.querySelectorAll('video').forEach(video => {
                video.addEventListener('error', () => {
                    console.error('Video error - moving to next');
                    videoCarousel.next();
                });
            });
            const videoCarouselInstance = new bootstrap.Carousel(document.getElementById('videoCarousel'), {
                interval: false, // Set to false to disable automatic carousel sliding (handled manually)
                wrap: true,
                keyboard: false
            });



            // Fix notice ticker if needed
            const noticeContainer = document.querySelector('.slider');
            const slideTrack = document.querySelector('.slide-track');
            const notices = document.querySelectorAll('.slide-track p');

            // Clone notices if there are not enough for smooth looping
            if (notices.length > 0 && notices.length < 5) {
                notices.forEach(notice => {
                    const clone = notice.cloneNode(true);
                    slideTrack.appendChild(clone);
                });
            }

            // Ensure that the sliding works smoothly by adjusting the timing if there are too few items
            if (slideTrack.scrollWidth <= noticeContainer.clientWidth) {
                const animationDuration = (slideTrack.scrollWidth / 100) * 30; // Adjusted from 80 to 40
                slideTrack.style.animationDuration = `${animationDuration}s`;
            }
        });
    </script>
</div>
