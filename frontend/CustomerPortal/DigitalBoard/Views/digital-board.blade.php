@extends('digitalBoard.layout')
@section('hero')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.10.377/pdf.min.js"></script>

    <div class="container mx-auto my-8 px-4">
        <div class="flex justify-center flex-col sm:flex-row gap-6 font-inter h-auto overflow-hidden">
            <!-- Notices Section -->
            <div class="bg-white rounded-lg shadow-md p-4 w-full sm:w-7/12 flex flex-col h-full overflow-hidden">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold text-gray-800">{{ __('Notices') }}</h3>
                    <a href="{{ route('digital-board.notice.show') }}"
                        class="bg-gradient-to-r from-blue-600 to-blue-800 hover:bg-blue-600 px-4 py-2 rounded-md flex items-center gap-2">
                        <span class="text-white text-sm">{{ __('View All') }}</span>
                        <img src="{{ asset('digitalBoard/icons/arrowRight.png') }}" class="w-5 h-5">
                    </a>
                </div>



                <hr class="border-gray-200 mb-4">

                <div id="slider" class="relative flex transition-transform duration-700 ease-in-out flex-grow">
                    @foreach ($notices as $notice)
                        <div class="notice-slide min-w-full bg-white p-4 flex flex-col h-full">
                            <!-- Image/PDF Container with Max Height -->
                            <div
                                class="relative group flex justify-center items-center w-full h-[250px] sm:h-[300px] md:h-[300px] lg:h-[320px] overflow-hidden rounded-md border border-gray-200">
                                @php
                                    $fileExtension = strtolower(pathinfo($notice->file, PATHINFO_EXTENSION));
                                @endphp

                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                    <img src="{{ asset('storage/digital-board/notices/' . $notice->file) }}"
                                        alt="Notice Image" class="w-full h-full object-cover object-center">
                                @elseif ($fileExtension === 'pdf')
                                    <div id="pdf-container-{{ $notice->id }}"
                                        class="pdf-container w-full h-full relative flex justify-center">
                                        <a href="{{ route('digital-board.notice.showDetail', ['id' => $notice->id]) }}">
                                            <!-- Hover Button Now Works -->
                                            <button id="read-more-button-{{ $notice->id }}"
                                                class="absolute inset-0 flex items-center justify-center text-sm font-medium text-white border border-white rounded bg-black bg-opacity-30 hover:bg-opacity-40 group-hover:opacity-100 opacity-0 transition-opacity duration-300">
                                                {{ __('Read More') }}
                                            </button>
                                        </a>
                                    </div>
                                    <script>
                                        (function() {
                                            const pdfUrl = "{{ asset('storage/digital-board/notices/' . $notice->file) }}";
                                            const container = document.getElementById("pdf-container-{{ $notice->id }}");

                                            function renderPDF() {
                                                pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc) {
                                                    pdfDoc.getPage(1).then(function(page) {
                                                        const canvas = container.querySelector("canvas") || document.createElement(
                                                            "canvas");
                                                        if (!canvas.parentNode) container.insertBefore(canvas, container.firstChild);

                                                        const context = canvas.getContext("2d");

                                                        const containerWidth = container.clientWidth;
                                                        const containerHeight = container.clientHeight;

                                                        const viewport = page.getViewport({
                                                            scale: 1
                                                        });
                                                        const scale = Math.min(containerWidth / viewport.width, containerHeight /
                                                            viewport.height);

                                                        canvas.width = viewport.width * scale;
                                                        canvas.height = viewport.height * scale;

                                                        canvas.style.width = `${canvas.width}px`;
                                                        canvas.style.height = `${canvas.height}px`;

                                                        page.render({
                                                            canvasContext: context,
                                                            viewport: page.getViewport({
                                                                scale
                                                            })
                                                        });
                                                    });
                                                });
                                            }

                                            renderPDF();
                                            window.addEventListener("resize", renderPDF);
                                        })
                                        ();
                                    </script>
                                @endif
                            </div>


                            <!-- Text Description with Scrollable Overflow -->
                            <div
                                class="mt-4 flex-grow overflow-auto max-h-[200px] p-4 bg-white border border-gray-200 rounded-lg shadow-sm 
                            hover:bg-gray-50 hover:shadow-md transition-all duration-300 ease-in-out transform group hover:scale-105 space-y-3">
                                <h2 class="text-xl font-semibold text-gray-800 truncate">{{ $notice->title }}</h2>
                                <p
                                    class="text-sm text-gray-600 line-clamp-1 group-hover:line-clamp-3 transition-all duration-300 ease-in-out">
                                    {{ $notice->description }}
                                </p>
                                <a href="{{ route('digital-board.notice.showDetail', ['id' => $notice->id]) }}"
                                    class="inline-block px-3 py-1 bg-blue-500 text-white text-sm font-medium rounded-full shadow-sm 
                                      hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75">
                                    {{ __('Read full notice') }}
                                </a>
                                <p class="text-xs text-gray-400">
                                    {{ $notice->created_at->diffForHumans() }}
                                </p>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Citizen Charter Section -->
            <div class="bg-white rounded-lg shadow-md p-4 w-full sm:w-4/12 h-full overflow-hidden flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl md:text-sm lg:text-xl font-bold text-gray-800">{{ __('Citizen Charter') }}</h3>
                    <a href="{{ route('digital-board.charter.showDetail', ['id' => \Src\DigitalBoard\Models\CitizenCharter::latest()?->first()?->id]) }}"
                        class="bg-gradient-to-r from-blue-600 to-blue-800 px-4 py-2 rounded-md flex items-center gap-2 hover:scale-105 transition-transform">
                        <span class="text-white text-sm">{{ __('View All') }}</span>
                        <img src="{{ asset('digitalBoard/icons/arrowRight.png') }}" class="w-5 h-5">
                    </a>
                </div>

                <hr class="border-gray-200 mb-4 opacity-40">

                <div class="flex flex-col gap-3 overflow-y-auto max-h-[300px] md:max-h-[530px]">
                    @foreach ($citizenCharters as $citizenCharter)
                        <div class="bg-[#1E3A8A] rounded-lg flex flex-col p-3">
                            <div class="flex items-center justify-center mb-2">
                                <h4 class="text-lg font-semibold text-white truncate">{{ $citizenCharter->service }}</h4>
                            </div>
                            <div class="bg-[#EFF6FF] rounded-b-lg p-2 flex justify-between items-center">
                                <div>
                                    <span class="font-bold text-[#D7263D] text-sm">{{ $citizenCharter->amount }}</span>
                                    <p class="text-xs text-gray-700">{{ $citizenCharter->time }}</p>
                                </div>
                                <div class="hidden lg:block">
                                    <a href="{{ route('digital-board.charter.showDetail', ['id' => $citizenCharter->id]) }}"
                                        class="flex items-center gap-1 bg-gradient-to-r from-blue-600 to-blue-800 rounded-md px-3 py-1 text-white text-xs hover:scale-105 transition-transform">
                                        <span>{{ __('View') }}</span>
                                        <img src="{{ asset('digitalBoard/icons/arrowRight.png') }}" alt="arrow"
                                            class="w-5 h-5">
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection




@section('content')
    {{-- testing section for program  --}}

    <div class="flex flex-col w-[98%] md:flex-row gap-y-8 md:gap-4 justify-around h-auto md:h-[300px] px-4 md:px-0">
        <!-- Recent Videos Section -->
        <div class="bg-white rounded-lg shadow-md p-3 md:p-4 h-full w-full md:w-1/2 flex flex-col">
            <div class="flex justify-between items-center mb-3 md:mb-4">
                <p class="text-lg md:text-xl text-dark font-medium">{{ __('Recent Videos') }}</p>
                <a href="{{ route('digital-board.video.show') }}">
                    <button
                        class="bg-gradient-to-r from-blue-600 to-blue-800 px-3 py-1 rounded-[10px] text-white text-xs md:text-sm flex items-center gap-1">
                        {{ __('View') }}
                        <img src="{{ asset('digitalBoard/icons/arrowRight.png') }}" alt="right arrow"
                            class="h-[10px] md:h-[12px] w-[18px] md:w-[20px]">
                    </button>
                </a>
            </div>

            <!-- Video Slider Container -->
            <div class="flex-1 overflow-hidden relative">
                <div id="videoSliderWrapper" class="overflow-hidden relative w-full">


                    <div class="flex-1 overflow-hidden relative">
                        <div id="videoSliderWrapper" class="overflow-hidden relative w-full">
                            <div id="videoSlider"
                                class="flex gap-4 md:gap-5 no-scrollbar transition-transform duration-700 ease-in-out">
                                @foreach ($videos as $video)
                                    <a href="{{ route('digital-board.video.showDetail', ['id' => $video->id]) }}"
                                        class="flex-none w-[calc(50%-16px)] sm:w-[calc(33.33%-16px)] min-w-[150px] md:min-w-[180px]">
                                        <div class="flex flex-col gap-2 md:gap-3">
                                            <div class="rounded-lg overflow-hidden h-32 md:h-40">
                                                <img src="{{ getVideoThumbnail($video) }}" alt="thumbnail"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                            </div>
                                            <div class="px-1">
                                                <p class="text-dark text-xs md:text-sm font-semibold truncate">
                                                    {{ $video->title }}</p>
                                                <span
                                                    class="text-status text-[11px] md:text-[13px]">{{ $video->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        <!-- Recent Programs Section (similar structure) -->
        <div class="bg-white rounded-lg shadow-md p-3 md:p-4 h-full w-full md:w-1/2 flex flex-col">
            <div class="flex justify-between items-center mb-3 md:mb-4">
                <p class="text-lg md:text-xl text-dark font-medium">{{ __('Recent Programs') }}</p>
                <a href="{{ route('digital-board.video.show') }}">
                    <button
                        class="bg-gradient-to-r from-blue-600 to-blue-800 px-3 py-1 rounded-[10px] text-white text-xs md:text-sm flex items-center gap-1">
                        {{ __('View') }}
                        <img src="{{ asset('digitalBoard/icons/arrowRight.png') }}" alt="right arrow"
                            class="h-[10px] md:h-[12px] w-[18px] md:w-[20px]">
                    </button>
                </a>
            </div>

            <!-- Video Slider Container -->
            <div class="flex-1 overflow-hidden relative">
                <div id="programSliderWrapper" class="overflow-hidden relative w-full">


                    <div class="flex-1 overflow-hidden relative">
                        <div id="videoSliderWrapper" class="overflow-hidden relative w-full">
                            <div id="programSlider"
                                class="flex gap-4 md:gap-5 no-scrollbar transition-transform duration-700 ease-in-out">
                                @foreach ($programs as $program)
                                    <a href="{{ route('digital-board.video.showDetail', ['id' => $program->id]) }}"
                                        class="flex-none w-[calc(50%-16px)] sm:w-[calc(33.33%-16px)] min-w-[150px] md:min-w-[180px]">
                                        <div class="flex flex-col gap-2 md:gap-3">
                                            <div class="rounded-lg overflow-hidden h-32 md:h-40">
                                                <img src="{{ customAsset(config('src.DigitalBoard.program.photo_path'), $program->photo) }}"
                                                    alt="thumbnail"
                                                    class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                            </div>
                                            <div class="px-1">
                                                <p class="text-dark text-xs md:text-sm font-semibold truncate">
                                                    {{ $program->title }}</p>
                                                <span
                                                    class="text-status text-[11px] md:text-[13px]">{{ $program->created_at->diffForHumans() }}</span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>

    {{-- employee section here --}}


    <hr class="mt-4 py-2">

    <div class="flex flex-col w-[98%] md:flex-row gap-y-8 md:gap-4 justify-around h-auto md:h-[300px] px-4 md:px-0">


        <!-- Representatives Section -->
        <div class="bg-white rounded-lg shadow-md p-3 md:p-4 h-full w-full md:w-1/2 flex flex-col">

            <div class="flex items-center mb-3 md:mb-4">
                <p class="text-lg md:text-xl text-dark font-medium">{{ __('Our Representatives') }}</p>
            </div>


            <!-- Representatives Slider Container -->
            @if($representatives)
            <div class="flex-1 overflow-hidden relative">
                <div id="representativeSliderWrapper" class="overflow-hidden relative w-full">
                    <div id="representativeSlider"
                        class="flex gap-4 md:gap-5 no-scrollbar transition-transform duration-700 ease-in-out">
                        @foreach ($representatives as $representative)
                            <div
                                class="flex-none w-[calc(50%-16px)] sm:w-[calc(33.33%-16px)] min-w-[150px] md:min-w-[180px]">
                                <div class="flex flex-col gap-2 md:gap-3">
                                    <div class="rounded-lg overflow-hidden h-32 md:h-40 relative group">
                                        <img src="{{ customAsset(config('src.Employees.employee.photo_path'), $representative->photo) }}"
                                            alt="{{ $representative->name }}"
                                            class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>

                                    <div class="px-1 text-center leading-tight">
                                        <p class="text-dark  text-sm sm:text-base font-semibold truncate">
                                            {{ $representative->title }}</p>
                                        <span class="text-status text-[13px] ">
                                            {{ $representative->designation->title ?? 'No Designation' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>



        <!-- Employees Section -->
        <div class="bg-white rounded-lg shadow-md p-3 md:p-4 h-full w-full md:w-1/2 flex flex-col">


            <!-- Employees Slider Container -->
            <div class="flex-1 overflow-hidden relative">
                <div class="flex justify-between items-center mb-3 md:mb-4">
                    <p class="text-lg md:text-xl text-dark font-medium">{{ __('Our Employee') }}</p>
                    <hr>
                </div>
                <div id="employeeSliderWrapper" class="overflow-hidden relative w-full">
                    <div id="employeeSlider"
                        class="flex gap-4 md:gap-5 no-scrollbar transition-transform duration-700 ease-in-out">
                        @foreach ($employees as $employee)
                            <div
                                class="flex-none w-[calc(50%-16px)] sm:w-[calc(33.33%-16px)] min-w-[150px] md:min-w-[180px]">
                                <div class="flex flex-col gap-2 md:gap-3">
                                    <div class="rounded-lg overflow-hidden h-32 md:h-40 relative group">
                                        <img src="{{ customAsset(config('src.Employees.employee.photo_path'), $employee->photo) }}"
                                            alt="{{ $employee->name }}"
                                            class="w-full h-full object-cover transform transition-transform duration-300 group-hover:scale-105">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        </div>
                                    </div>
                                    <div class="px-1 text-center leading-tight">
                                        <p class="text-dark text-sm sm:text-base font-semibold truncate ">
                                            {{ $employee->name }}</p>
                                        <span class="text-status text-[13px] ">
                                            {{ $employee->designation->title ?? 'No Designation' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


    </div>



    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize all sliders with proper configuration
            initSliderPair('videoSlider', 'programSlider');
            initSliderPair('employeeSlider', 'representativeSlider');
        });

        function initSliderPair(sliderId1, sliderId2) {
            const slider1 = initSingleSlider(sliderId1);
            const slider2 = initSingleSlider(sliderId2);
            let activeSlider = slider1;

            // Alternate between sliders every 3 seconds
            setInterval(() => {
                activeSlider = activeSlider === slider1 ? slider2 : slider1;
                activeSlider.nextSlide();
            }, 3000);
        }

        function initSingleSlider(sliderId) {
            const slider = document.getElementById(sliderId);
            if (!slider) return null;

            const container = slider.parentElement;
            const slides = slider.children;
            if (slides.length === 0) return null;

            // Calculate real gap and slide width
            const gap = parseInt(window.getComputedStyle(slider).gap) || 0;
            let slideWidth = slides[0].offsetWidth + gap;

            // Clone slides for seamless transition
            slider.innerHTML += slider.innerHTML;

            let currentIndex = 0;
            let isTransitioning = false;

            function nextSlide() {
                if (isTransitioning) return;
                isTransitioning = true;

                currentIndex++;
                slider.style.transition = 'transform 0.7s ease-in-out';
                slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

                // Reset position when reaching cloned set
                if (currentIndex >= slides.length / 2) {
                    setTimeout(() => {
                        slider.style.transition = 'none';
                        slider.style.transform = 'translateX(0)';
                        currentIndex = 0;
                        isTransitioning = false;
                    }, 700);
                } else {
                    setTimeout(() => isTransitioning = false, 700);
                }
            }

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    slideWidth = slides[0].offsetWidth + gap;
                }, 250);
            });

            // Pause on hover
            container.addEventListener('mouseenter', () => isTransitioning = true);
            container.addEventListener('mouseleave', () => isTransitioning = false);

            return {
                nextSlide
            };
        }
    </script>











    {{-- <div class="mb-6">
        <!-- Employee -->
        <div
            class=" mx-2 sm:max-w-[800px] lg:max-w-[900px] xl:max-w-[1000px] 2xl:max-w-[1400px] sm:mx-auto  flex flex-col items-center bg-component rounded rounded-md p-4 overflow-hidden font-inter">
            <div class="flex justify-between  items-center w-full mb-3">
                <p class="text-xl sm:text-3xl text-dark font-medium">{{ __('Employees') }}</p>
                <a href="{{ route('digital-board.employee.show') }}">
                    <button
                        class="bg-gradient-to-r from-[#103268b3] to-[#103268e6] px-3 py-1 rounded rounded-[10px] text-white py-2 px-1 rounded mt-2 text-sm flex items-center justify-center gap-1">
                        {{ __('View') }}
                        <img src="{{ asset('digitalBoard/icons/arrowRight.png') }}" alt="right arrow"
                            class="h-[12px] w-[20px]" />
                    </button>
                </a>
            </div>
            <hr class="h-[2px] bg-slate-300 w-full my-2">
            <div class="w-full flex flex-row gap-5 hide-scrollbar-x overflow-x-auto">
                @foreach ($employees as $employee)
                    <div class="min-w-[200px] px-0 py-2 flex  flex-col justify-start">
                        <div class="rounded rounded-lg bg-white flex justify-center items-center px-8 py-2">
                            <img src="{{ customAsset(config('src.Employees.employee.photo_path'), $employee->photo) }}"
                                alt="{{ $employee->name }}" class="h-[150px] w-full">
                        </div>
                        <div class="text-center mt-2 leading-tight">
                            <p class="text-dark text-sm sm:text-base  font-semibold">{{ $employee->name }}</p>
                            <span
                                class="mt-1 text-status text-[13px]">{{ $employee->designation->title ?? 'No Designations' }}</span>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div> --}}
@endsection



@section('scripts')
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            const popup = document.getElementById('popupModal');
            const overlay = document.getElementById('overlay');
            const closeButton = document.getElementById('closePopup');

            popup.classList.remove('hidden');
            overlay.classList.remove('hidden');
            const displayDuration = {{ $popupData['display_duration'] ?? 0 }} * 1000;

            setTimeout(() => {
                popup.classList.add('hidden');
                overlay.classList.add('hidden');
            }, displayDuration);

            closeButton.addEventListener('click', () => {
                popup.classList.add('hidden');
                overlay.classList.add('hidden');
            });

            overlay.addEventListener('click', () => {
                popup.classList.add('hidden');
                overlay.classList.add('hidden');
            });
        });

        // script for custom scrollbar
        document.addEventListener("DOMContentLoaded", function() {
            function applyCustomScrollbar(selector, direction = "y") {
                const scrollableDiv = document.querySelector(selector);
                if (!scrollableDiv) return;

                // Ensure scrollbar exists
                if (direction === "y") {
                    scrollableDiv.style.overflowY = "scroll"; // Enable vertical scroll
                } else if (direction === "x") {
                    scrollableDiv.style.overflowX = "scroll"; // Enable horizontal scroll
                }

                // Add custom scrollbar styles dynamically
                const style = document.createElement("style");
                style.innerHTML =
                    `
                                                                                                                                                                                        ${selector}::-webkit-scrollbar {
                                                                                                                                                                                            ${direction === "y" ? "width: 8px;" : "height: 8px;"} /* Adjust width or height */
                                                                                                                                                                                            display: block !important;
                                                                                                                                                                                        }
                                                                                                                                                                                        ${selector}::-webkit-scrollbar-track {
                                                                                                                                                                                            background: #f1f1f1;
                                                                                                                                                                                            border-radius: 10px;
                                                                                                                                                                                        }
                                                                                                                                                                                        ${selector}::-webkit-scrollbar-thumb {
                                                                                                                                                                                            background: #888;
                                                                                                                                                                                            border-radius: 10px;
                                                                                                                                                                                        }
                                                                                                                                                                                        ${selector}::-webkit-scrollbar-thumb:hover {
                                                                                                                                                                                            background: #555;
                                                                                                                                                                                        }
                                                                                                                                                                                    `;
                document.head.appendChild(style);
            }

            // Apply for both vertical and horizontal scrollbars
            applyCustomScrollbar(".hide-scrollbar-y", "y"); // For vertical scroll
            applyCustomScrollbar(".hide-scrollbar-x", "x"); // For horizontal scroll
        });

        document.addEventListener("DOMContentLoaded", function() {
            const slider = document.getElementById("slider");
            const slides = document.querySelectorAll(".notice-slide");
            const slideCount = slides.length;
            let currentIndex = 0;

            // Clone the first slide and append it for smooth looping
            const firstClone = slides[0].cloneNode(true);
            slider.appendChild(firstClone);

            function nextSlide() {
                currentIndex++;

                // Apply sliding transition
                slider.style.transition = "transform 0.7s ease-in-out";
                slider.style.transform = `translateX(-${currentIndex * 100}%)`;

                // When reaching the last cloned slide, reset to first slide without transition
                if (currentIndex === slideCount) {
                    setTimeout(() => {
                        slider.style.transition = "none";
                        slider.style.transform = "translateX(0%)";
                        currentIndex = 0;
                    }, 700); // Wait for transition to finish before resetting
                }
            }

            // Auto-slide every 5 seconds
            function startSlider() {
                interval = setInterval(nextSlide, 5000);
            }

            function stopSlider() {
                clearInterval(interval);
            }

            // Auto-slide
            startSlider();

            // Pause on hover
            slider.addEventListener("mouseenter", stopSlider);
            slider.addEventListener("mouseleave", startSlider);
        }); <
        />
    @endsection
