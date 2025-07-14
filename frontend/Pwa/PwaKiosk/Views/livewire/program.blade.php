<div class="notice-component-wrapper">
    <!-- Date Filter Controls - Preserving all Livewire functionality -->
    <div class="filter-controls-container mb-4">
        <div class="d-flex flex-wrap justify-content-end gap-3">
            <!-- Start Date Filter -->
            <div class="date-filter-wrapper">
                <div class="d-flex align-items-center">
                    <button
                        class="btn btn-primary d-flex align-items-center gap-2 px-4"style="background-color: #01399a;"
                        data-bs-toggle="collapse" data-bs-target="#toggleStartDate">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                            height="22" width="22" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M960 95.888l-256.224.001V32.113c0-17.68-14.32-32-32-32s-32 14.32-32 32v63.76h-256v-63.76c0-17.68-14.32-32-32-32s-32 14.32-32 32v63.76H64c-35.344 0-64 28.656-64 64v800c0 35.343 28.656 64 64 64h896c35.344 0 64-28.657 64-64v-800c0-35.329-28.656-63.985-64-63.985zm0 863.985H64v-800h255.776v32.24c0 17.679 14.32 32 32 32s32-14.321 32-32v-32.224h256v32.24c0 17.68 14.32 32 32 32s32-14.32 32-32v-32.24H960v799.984zM736 511.888h64c17.664 0 32-14.336 32-32v-64c0-17.664-14.336-32-32-32h-64c-17.664 0-32 14.336-32 32v64c0 17.664 14.336 32 32 32zm0 255.984h64c17.664 0 32-14.32 32-32v-64c0-17.664-14.336-32-32-32h-64c-17.664 0-32 14.336-32 32v64c0 17.696 14.336 32 32 32zm-192-128h-64c-17.664 0-32 14.336-32 32v64c0 17.68 14.336 32 32 32h64c17.664 0 32-14.32 32-32v-64c0-17.648-14.336-32-32-32zm0-255.984h-64c-17.664 0-32 14.336-32 32v64c0 17.664 14.336 32 32 32h64c17.664 0 32-14.336 32-32v-64c0-17.68-14.336-32-32-32zm-256 0h-64c-17.664 0-32 14.336-32 32v64c0 17.664 14.336 32 32 32h64c17.664 0 32-14.336 32-32v-64c0-17.68-14.336-32-32-32zm0 255.984h-64c-17.664 0-32 14.336-32 32v64c0 17.68 14.336 32 32 32h64c17.664 0 32-14.32 32-32v-64c0-17.648-14.336-32-32-32z">
                            </path>
                        </svg>
                        <span>शुरु</span>
                    </button>

                    <div class="ms-3">
                        <div class="collapse date-picker-dropdown" id="toggleStartDate">
                            <div class="input-group">
                                <input type="text" class="form-control nepali-date" id="start_date"
                                    value="{{ request('start_date') }}" wire:model="start_date" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- End Date Filter -->
            <div class="date-filter-wrapper">
                <div class="d-flex align-items-center">
                    <button
                        class="btn btn-primary d-flex align-items-center gap-2 px-4"style="background-color: #01399a;"
                        data-bs-toggle="collapse" data-bs-target="#toggleEndDate">
                        <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 1024 1024"
                            height="22" width="22" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M960 95.888l-256.224.001V32.113c0-17.68-14.32-32-32-32s-32 14.32-32 32v63.76h-256v-63.76c0-17.68-14.32-32-32-32s-32 14.32-32 32v63.76H64c-35.344 0-64 28.656-64 64v800c0 35.343 28.656 64 64 64h896c35.344 0 64-28.657 64-64v-800c0-35.329-28.656-63.985-64-63.985zm0 863.985H64v-800h255.776v32.24c0 17.679 14.32 32 32 32s32-14.321 32-32v-32.224h256v32.24c0 17.68 14.32 32 32 32s32-14.32 32-32v-32.24H960v799.984zM736 511.888h64c17.664 0 32-14.336 32-32v-64c0-17.664-14.336-32-32-32h-64c-17.664 0-32 14.336-32 32v64c0 17.664 14.336 32 32 32zm0 255.984h64c17.664 0 32-14.32 32-32v-64c0-17.664-14.336-32-32-32h-64c-17.664 0-32 14.336-32 32v64c0 17.696 14.336 32 32 32zm-192-128h-64c-17.664 0-32 14.336-32 32v64c0 17.68 14.336 32 32 32h64c17.664 0 32-14.32 32-32v-64c0-17.648-14.336-32-32-32zm0-255.984h-64c-17.664 0-32 14.336-32 32v64c0 17.664 14.336 32 32 32h64c17.664 0 32-14.336 32-32v-64c0-17.68-14.336-32-32-32zm-256 0h-64c-17.664 0-32 14.336-32 32v64c0 17.664 14.336 32 32 32h64c17.664 0 32-14.336 32-32v-64c0-17.68-14.336-32-32-32zm0 255.984h-64c-17.664 0-32 14.336-32 32v64c0 17.68 14.336 32 32 32h64c17.664 0 32-14.32 32-32v-64c0-17.648-14.336-32-32-32z">
                            </path>
                        </svg>
                        <span>अन्त्य</span>
                    </button>

                    <div class="ms-3">
                        <div class="collapse date-picker-dropdown" id="toggleEndDate">
                            <div class="input-group">
                                <input type="text" class="form-control nepali-date" id="end_date"
                                    value="{{ request('end_date') }}" wire:model="end_date" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Button -->
            <div>
                <button class="btn btn-primary d-flex align-items-center gap-2 px-4" wire:click="filterDate"
                    style="background-color: #01399a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    <span>फिल्टर गर्नुहोस्</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Notices Section -->
    <div class="notices-section"style="color: #01399a;">
        <div class="section-header mb-4">
            <div class="section-title">
                <div class="icon-wrapper"style="color: #01399a;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect x="2" y="3" width="20" height="14" rx="2"></rect>
                        <path d="M8 21h8"></path>
                        <path d="M12 17v4"></path>
                    </svg>
                </div>
                <span class="fs-4 fw-500"style="color: #01399a;">प्रोग्रामहरू</span>
            </div>
        </div>

        <!-- Notice Carousel - Preserving original structure but with programs -->
        <div id="videoCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="notice-slider-container">
                        <!-- Program Grid as Slider -->
                        <div class="notice-slider">
                            @if (count($programs) > 0)
                                @foreach ($programs as $program)
                                    <div class="notice-card-wrapper">
                                        <div class="app-card h-100">
                                            <div class="card-img-container">
                                                <img src="{{ customAsset(config('src.DigitalBoard.program.photo_path'), $program->photo) }}"
                                                    class="card-img-top" alt="{{ $program->title }}">
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $program->title }}</h5>
                                                @if (isset($program->description))
                                                    <p class="card-text small text-muted">
                                                        {{ Str::limit($program->description, 100) }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="w-100 text-center py-5">
                                    <div class="alert alert-info d-inline-block">
                                        <p class="mb-0">कुनै प्रोग्राम उपलब्ध छैन</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Navigation Controls -->
                        @if (count($programs) > 0)
                            <div class="slider-controls">
                                <button class="slider-nav-button video-prev"
                                    style="background-color: #01399a;">&lt;</button>
                                <button
                                    class="slider-nav-button video-next"style="background-color: #01399a;">&gt;</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if (method_exists($programs, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $programs->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        /* Component wrapper */
        .notice-component-wrapper {
            padding: 1.5rem;
            background-color: #fff;
        }

        /* Filter controls styling */
        .filter-controls-container {
            background-color: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
        }

        .date-filter-wrapper {
            position: relative;
        }

        .date-picker-dropdown {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            min-width: 250px;
            margin-top: 0.5rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
        }

        /* Section header styling */
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .section-title {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: #0d6efd;
        }

        .icon-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(13, 110, 253, 0.1);
            border-radius: 50%;
            margin-right: 0.75rem;
        }

        /* Notice slider styling */
        .notice-slider-container {
            position: relative;
            padding: 0 30px;
        }

        .notice-slider {
            display: flex;
            overflow-x: auto;
            scroll-behavior: smooth;
            gap: 15px;
            padding: 10px 0;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        .notice-slider::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .notice-card-wrapper {
            flex: 0 0 auto;
            width: 250px;
        }

        /* Card styling */
        .app-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .app-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }

        .card-img-container {
            height: 180px;
            overflow: hidden;
        }

        .card-img-top {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .app-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Slider controls */
        .slider-controls {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .slider-nav-button {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #0d6efd;
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

        /* Pagination styling */
        .pagination {
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #0d6efd;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .date-picker-dropdown {
                position: static;
                width: 100%;
                margin-top: 0.5rem;
            }

            .date-filter-wrapper {
                width: 100%;
                margin-bottom: 1rem;
            }

            .notice-card-wrapper {
                width: 85%;
                max-width: 250px;
            }
        }
    </style>
</div>

@script
    <script>
        // Preserving the original date picker functionality


        // Adding slider functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sliderElement = document.querySelector('.notice-slider');
            const prevBtn = document.querySelector('.video-prev');
            const nextBtn = document.querySelector('.video-next');

            if (sliderElement && prevBtn && nextBtn) {
                const sliderItems = sliderElement.querySelectorAll('.notice-card-wrapper');

                if (sliderItems.length) {
                    const scrollDistance = () => {
                        return sliderItems[0].offsetWidth + 15;
                    };

                    prevBtn.addEventListener('click', function() {
                        sliderElement.scrollLeft -= scrollDistance();
                    });

                    nextBtn.addEventListener('click', function() {
                        sliderElement.scrollLeft += scrollDistance();
                    });

                    let autoSlideInterval;

                    function startAutoSlide() {
                        autoSlideInterval = setInterval(() => {
                            if (sliderElement.scrollLeft >= sliderElement.scrollWidth - sliderElement
                                .clientWidth - 10) {
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
                }
            }
        });
    </script>
@endscript
