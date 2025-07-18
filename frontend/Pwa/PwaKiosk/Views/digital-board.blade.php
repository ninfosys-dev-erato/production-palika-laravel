<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #01399a;
            --secondary-color: #6c757d;
            --light-bg: #f8f9fa;
            --card-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 0.5rem;
            --section-spacing: 2rem;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-bg);
        }

        /* Section styling */
        .app-section {
            margin-bottom: var(--section-spacing);
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            padding: 1.5rem;
        }

        /* Section headers */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--primary-color);
        }

        .section-title .icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
            margin-right: 0.75rem;
        }

        .view-all-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .view-all-link:hover {
            color: #0a58ca;
            text-decoration: underline;
        }

        /* Card styling */
        .app-card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            overflow: hidden;
        }

        .app-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .app-card .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        /* Slider components */
        .slider-container {
            position: relative;
            padding: 0 30px;
        }

        .horizontal-slider {
            display: flex;
            overflow-x: hidden;
            scroll-behavior: smooth;
            gap: 15px;
            padding: 10px 0;
        }

        .slider-item {
            flex: 0 0 auto;
        }

        /* Navigation buttons */
        .slider-nav-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .slider-nav-button:hover {
            background-color: #0a58ca;
        }

        .slider-controls {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        /* Main carousel */
        /* Main carousel - fixed height */
        .main-carousel {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            height: 500px; /* Fixed height */
        }

        .main-carousel .carousel-inner {
            height: 100%;
        }

        .main-carousel .carousel-item {
            height: 100%;
        }

        .carousel-image-container {
            height: 100%;
        }

        .main-carousel img {
            object-fit: cover;
            height: 500px;
            width: 100%;
        }
        .main-carousel .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 0.25rem;
            padding: 1rem;
            bottom: 0;
            left: 0;
            right: 0;
        }

        /* Citizen Charter */
        .citizen-charter-container {
            height: 100%;
            background-color: #f8f9fa;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .citizen-charter-header {
            background-color: var(--primary-color);
            color: white;
            padding: 1rem;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .citizen-charter-list {
            max-height: 350px;
            overflow-y: auto;
            padding: 1rem;
        }

        .citizen-charter-item {
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            margin-bottom: 0.75rem;
            overflow: hidden;
        }

        .citizen-charter-item-header {
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem;
            text-align: center;
        }

        .citizen-charter-item-body {
            padding: 0.75rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
        }

        /* Video grid */
        .video-grid .card-video-container {
            height: 200px;
            position: relative;
            background-color: #000;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            overflow: hidden;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .slider-item {
                width: calc(50% - 8px);
            }
        }

        @media (min-width: 992px) {
            .slider-item {
                width: calc(33.333% - 10px);
            }
        }

        @media (min-width: 1200px) {
            .slider-item {
                width: calc(25% - 12px);
            }
        }

        /* For small screens */
        @media (max-width: 767.98px) {
            .slider-item {
                width: 85%;
                max-width: 18rem;
            }
        }

        /* Custom button styles */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
</head>

<body>
<div class="container py-4">
    <!-- Hero Section with Main Carousel and Citizen Charter -->
    <section class="app-section">
        <div class="row g-4">
            <!-- Main Carousel Section -->
            <div class="col-12 col-md-8 col-xl-9 order-2 order-md-1">
                <div class="main-carousel">
                    <div id="mainCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner h-100 rounded-3">
                            @foreach($programs as $index => $program)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="carousel-image-container">
                                        <img src="{{ customAsset(config('src.DigitalBoard.program.photo_path'), $program->photo) }}"
                                             class="d-block w-100 mt-10" alt="{{ $program->title }}">
                                    </div>
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5 class="fw-bold mb-0">{{ $program->title }}</h5>
                                        @if(isset($program->description))
                                            <p class="mb-0 small">{{ Str::limit($program->description, 120) }}</p>
                                        @endif
                                    </div>
                                    <!-- Mobile caption (visible only on small screens) -->
                                    <div class="position-absolute bottom-0 start-0 end-0 p-3 bg-dark bg-opacity-75 d-md-none">
                                        <h5 class="text-white fw-bold mb-0 text-center">{{ $program->title }}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <button  class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Citizen Charter Section -->
            <div class="col-12 col-md-4 col-xl-3 order-1 order-md-2">
                <div class="citizen-charter-container h-100">
                    <div class="citizen-charter-header" style="background-color: #01399a;">
                        <h5 class="m-0">नागरीक वडापत्र</h5>
                        <a href="{{route('pwa.kiosk.citizen-charter', ['ward' => $ward]) }}" class="btn btn-sm btn-light">पुरा हर्नुहोस</a>
                    </div>

                    <div class="btn-group w-100 p-2" role="group">
                        <button  class="btn btn-sm btn-outline-primary" wire:click="isPalika()">
                            {{ __('Palika') }}
                        </button>
                        <button class="btn btn-sm btn-outline-primary" wire:click="isWard({{$ward}})">
                            {{ __('Ward') }}
                        </button>
                    </div>

                    <div class="citizen-charter-list">
                        @foreach ($citizenharters as $citizenCharter)
                            <div class="citizen-charter-item">
                                <div class="citizen-charter-item-header" style="background-color: #01399a;">
                                    <h6 class="m-0 text-truncate">{{ $citizenCharter->service }} </h6>
                                </div>
                                <div class="citizen-charter-item-body">
                                    <div>
                                        <span class="fw-bold text-danger small">{{ $citizenCharter->amount }}</span>
                                        <p class="text-muted mb-0 small">{{ $citizenCharter->time }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Notices Section -->
    <section class="app-section">
        <div class="section-header">
            <div class="section-title">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                    </svg>
                </div>
                <span>सूचनाहरू</span>
            </div>
            <a href="{{route('pwa.kiosk.notice', ['ward' => $ward]) }}" class="view-all-link">
                पुरा हर्नुहोस <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                   stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="slider-container">
            <div class="horizontal-slider notice-slider">
                @foreach($notices as $notice)
                    <div class="slider-item">
                        <div class="app-card">
                            <img src="{{ asset('storage/digital-board/notices/' . $notice->file) }}"
                                 class="card-img-top" alt="{{ $notice->title }}" style="height: 180px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{$notice->title}}</h5>
                                <p class="card-text small text-muted">
                                    {{ Str::limit($notice->description ?? '', 60) }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="slider-controls">
                <button class="slider-nav-button notice-prev">&lt;</button>
                <button class="slider-nav-button notice-next">&gt;</button>
            </div>
        </div>
    </section>

    <!-- Videos Section -->
    <section class="app-section">
        <div class="section-header">
            <div class="section-title">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                        <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                    </svg>
                </div>
                <span>प्रोग्रामहरू</span>
            </div>
            <a href="{{route('pwa.kiosk.program', ['ward' => $ward]) }}" class="view-all-link">
                पुरा हर्नुहोस <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                   stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="slider-container">
            <div class="horizontal-slider video-slider">
                @foreach($programs as $program)
                    <div class="slider-item">
                        <div class="app-card">
                            <div class="position-relative">
                                <img src="{{ customAsset(config('src.DigitalBoard.program.photo_path'), $program->photo) }}"
                                     class="card-img-top" alt="{{ $program->title }}" style="height: 180px; object-fit: cover;">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title text-truncate">{{$program->title}}</h5>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="slider-controls">
                <button class="slider-nav-button video-prev">&lt;</button>
                <button class="slider-nav-button video-next">&gt;</button>
            </div>
        </div>
    </section>

    <!-- Video Grid Section -->
    <section class="app-section">
        <div class="section-header">
            <div class="section-title">
                <div class="icon-wrapper">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                        <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                    </svg>
                </div>
                <span>भिडियोहरू</span>
            </div>
            <a href="{{route('pwa.kiosk.video', ['ward' => $ward]) }}" class="view-all-link">
                पुरा हर्नुहोस <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                   fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                   stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="m12 5 7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="video-grid">
            @if(count($videos) > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($videos as $video)
                        <div class="col">
                            <div class="app-card">
                                <div class="card-video-container">
                                    @if ($video->file)
                                        <iframe
                                            src="{{ customVideoAsset(config('src.DigitalBoard.video.video_path'), $video->file) }}"
                                            frameborder="0"
                                            class="position-absolute top-0 start-0 w-100 h-100"
                                            allow="autoplay; fullscreen; geolocation"
                                            referrerpolicy="no-referrer">
                                        </iframe>
                                    @elseif ($video->url)
                                        <iframe
                                            src="https://www.youtube.com/embed/{{ Str::afterLast($video->url, '=') }}"
                                            frameborder="0"
                                            class="position-absolute top-0 start-0 w-100 h-100"
                                            sandbox="allow-scripts allow-same-origin"
                                            loading="lazy"
                                            allow="autoplay; fullscreen; geolocation"
                                            referrerpolicy="no-referrer">
                                        </iframe>
                                    @endif
                                </div>
                                @if(isset($video->title))
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate">{{ $video->title }}</h5>
                                        @if(isset($video->description))
                                            <p class="card-text small text-muted">
                                                {{ Str::limit($video->description, 100) }}
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row justify-content-center my-5">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body text-center py-5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                     stroke-linejoin="round" class="text-muted mb-3">
                                    <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                                    <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                                </svg>
                                <h4 class="fw-bold text-dark">भिडियो उपलब्ध छैन</h4>
                                <p class="text-muted mb-0">अहिलेसम्म कुनै भिडियो अपलोड गरिएको छैन। कृपया पछि फेरि जाँच गर्नुहोस्।</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if(method_exists($videos, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $videos->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sliders = [
            { slider: '.notice-slider', prev: '.notice-prev', next: '.notice-next' },
            { slider: '.video-slider', prev: '.video-prev', next: '.video-next' }
        ];

        sliders.forEach(({ slider, prev, next }) => {
            const sliderElement = document.querySelector(slider);
            if (!sliderElement) return;

            const prevBtn = document.querySelector(prev);
            const nextBtn = document.querySelector(next);
            const sliderItems = sliderElement.querySelectorAll('.slider-item');

            if (!sliderItems.length) return;

            const scrollDistance = () => {
                return sliderItems[0].offsetWidth + 15;
            };

            prevBtn.addEventListener('click', function () {
                sliderElement.scrollLeft -= scrollDistance();
            });

            nextBtn.addEventListener('click', function () {
                sliderElement.scrollLeft += scrollDistance();
            });

            let autoSlideInterval;

            function startAutoSlide() {
                autoSlideInterval = setInterval(() => {
                    if (sliderElement.scrollLeft >= sliderElement.scrollWidth - sliderElement.clientWidth - 10) {
                        sliderElement.scrollLeft = 0;
                    } else {
                        sliderElement.scrollLeft += scrollDistance();
                    }
                }, 5000);
            }

            function stopAutoSlide() {
                clearInterval(autoSlideInterval);
            }

            startAutoSlide();

            sliderElement.addEventListener('mouseenter', stopAutoSlide);
            prevBtn.addEventListener('mouseenter', stopAutoSlide);
            nextBtn.addEventListener('mouseenter', stopAutoSlide);

            sliderElement.addEventListener('mouseleave', startAutoSlide);
            prevBtn.addEventListener('mouseleave', startAutoSlide);
            nextBtn.addEventListener('mouseleave', startAutoSlide);
        });

        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
</body>

</html>
