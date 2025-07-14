<div class="w-100 h-100 d-flex pt-3">
    <div class="d-flex flex-column" style="width: 25%;">
        <div class="d-flex align-items-center cursor-pointer mb-2" style="cursor: pointer;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                <path d="M4 11h12v2H4zm0-5h16v2H4zm0 12h7.235v-2H4z"></path>
            </svg>
            <p class="fw-medium fs-5 m-0 ms-1">मेनु</p>
        </div>
        <?php
$menus = [
    [
        "id" => "१",
        "title" => "सूचना",
        "link" => "notices",
    ],
    [
        "id" => "२",
        "title" => "कार्यक्रमहरु",
        "link" => "programs",
    ],
    [
        "id" => "३",
        "title" => "मिडिया",
        "link" => "videos",
    ],
    [
        "id" => "४",
        "title" => "जनप्रतिनिधिहरु",
        "link" => "representatives",
    ],
    [
        "id" => "५",
        "title" => "कर्मचारीहरु",
        "link" => "employees",
    ],
];
    ?>
        @foreach ($menus as $menu)
            <a href="{{ route('smartboard.' . $menu['link']) }}" class="text-decoration-none mt-1">
                <div class="w-100 d-flex justify-content-between align-items-center rounded-2 px-2 py-1 text-light"
                    style="background-color: var(--secondary)" wire:key="menu-{{ $menu['id'] }}">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                            style="height: 1.2rem; width: 1.2rem;">
                            <span class="text-primary" style="font-size: 0.8rem">{{ $menu['id'] }}</span>
                        </div>
                        <p class="m-0" style="font-size: 0.8rem">{{ $menu['title'] }}</p>
                    </div>
                </div>
            </a>
        @endforeach

        <!-- HTML Structure -->
        <div class="representative-section mt-3">
            <!-- Representatives Section -->
            <div class="w-100 d-flex justify-content-between align-items-center rounded-2 py-1 text-light"
                style="background-color: var(--secondary)">
                <p class="m-0 w-100 text-center" style="font-size: 0.8rem">जनप्रतिनिधि</p>
            </div>

            <div class="profile-carousel representative-carousel">
                <div class="carousel-track">
                    @foreach($representatives as $rep)
                        <div class="profile-card" wire:key="representative-{{ $rep->id }}">
                            <div class="profile-image-container d-flex w-100 justify-content-center">
                                <img src="{{ customAsset(config('src.Employees.employee.photo_path'), $rep->photo) }}"
                                    class="profile-image h-100" style="width: fit-content">
                            </div>
                            <div class="w-100 text-center mt-2">
                                <h3 class="profile-name m-0">{{ $rep->name ?? 'N/A' }}</h3>
                                <p class="profile-designation m-0">
                                    {{$rep->designation->title ?? 'No Designation' }}
                                </p>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Employees Section -->
            <div class="w-100 d-flex justify-content-between align-items-center rounded-2 py-1 text-light"
                style="background-color: var(--secondary)">
                <p class="m-0 w-100 text-center" style="font-size: 0.8rem">कर्मचारी</p>
            </div>

            <div class="profile-carousel employee-carousel">
                <div class="carousel-track">
                    @foreach($employees as $emp)
                        <div class="profile-card" wire:key="employee-{{ $emp->id }}">
                            <div class="profile-image-container d-flex w-100 justify-content-center">
                                <img src="{{ customAsset(config('src.Employees.employee.photo_path'), $emp->photo) }}"
                                    class="profile-image h-100" style="width: fit-content">
                            </div>
                            <div class="w-100 text-center mt-2">
                                <h3 class="profile-name m-0">{{ $emp->name }}</h3>
                                <p class="profile-designation m-0">
                                    {{$emp->designation->title ?? 'No Designation'  }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>
    <div class="h-100 pb-3 d-flex flex-column ms-3" style="width: 75%">
        @if (!empty($programs) && count($programs) > 0)
            <div class="program-slider">
                <div class="program-track">
                    @foreach($programs as $program)
                        <div class="program-slide" wire:key="program-{{ $program->id }}">
                            <div class="rounded-1 overflow-hidden d-flex justify-content-center w-100" style="height: 90%">
                                <img src="{{ customAsset(config('src.DigitalBoard.program.photo_path'), $program->photo)}}"
                                    alt="{{$program->title}}" class="h-100" style="width: fit-content;">
                            </div>
                            <p class="m-0 text-center mt-2 ms-2 fw-medium" style="color: var(--primary)">
                                {{$program->title}}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="rounded-1 overflow-hidden d-flex justify-content-center w-100" style="height: 90%">
                <img src="{{ getSetting('palika-logo') }}" alt="program" class="h-100" style="width: fit-content;">
            </div>
            <p class="text-center mt-2 ms-2">समृद्ध {{ getSetting('palika-name') }}, सभ्य समाज</p>
        @endif
    </div>
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
            height: 15vh;
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

        .program-slider {
            position: relative;
            overflow: hidden;
            height: 100%;
            width: 100%;
        }

        .program-track {
            display: flex;
            height: 100%;
            width: 100%;
            transition: transform 0.8s ease-in-out;
        }

        .program-slide {
            flex: 0 0 100%;
            width: 100%;
            height: 100%;
            position: relative;
        }

        .program-slide img {
            object-fit: contain;
            max-width: 100%;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            class Carousel {
                constructor(selector) {
                    this.container = document.querySelector(selector);
                    this.track = this.container.querySelector('.carousel-track');
                    this.items = Array.from(this.track.children);

                    // Clone first two items and append to end
                    const firstTwo = this.items.slice(0, 2).map(item => item.cloneNode(true));
                    firstTwo.forEach(item => this.track.appendChild(item));

                    this.position = 0;
                    this.totalItems = this.items.length;
                    this.slideWidth = 50; // 50% width per slide

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
            new Carousel('.representative-carousel');
            new Carousel('.employee-carousel');
            new ProgramSlider();
        });
    </script>
</div>