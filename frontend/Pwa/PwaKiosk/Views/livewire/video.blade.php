<section class="video-section py-5">

    <div class="container">
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
        <!-- Header with icon and title -->
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="text-primary">
                    <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5"></path>
                    <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                </svg>
            </div>
            <h2 class="fs-3 fw-bold m-0">भिडियोहरू</h2>
        </div>


        <!-- Video Grid -->
        <div id="videoGrid">
            @if (count($videos) > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach ($videos as $video)
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                                <div class="card-video-container position-relative" style="height: 200px;">
                                    @if ($video->file)
                                        <iframe
                                            src="{{ customVideoAsset(config('src.DigitalBoard.video.video_path'), $video->file) }}"
                                            frameborder="0" class="position-absolute top-0 start-0 w-100 h-100"
                                            allow="autoplay; fullscreen; geolocation" referrerpolicy="no-referrer">
                                        </iframe>
                                    @elseif ($video->url)
                                        <iframe
                                            src="https://www.youtube.com/embed/{{ Str::afterLast($video->url, '=') }}"
                                            frameborder="0" class="position-absolute top-0 start-0 w-100 h-100"
                                            sandbox="allow-scripts allow-same-origin" loading="lazy"
                                            allow="autoplay; fullscreen; geolocation" referrerpolicy="no-referrer">
                                        </iframe>
                                    @endif
                                </div>
                                @if (isset($video->title))
                                    <div class="card-body">
                                        <h5 class="card-title text-truncate">{{ $video->title }}</h5>
                                        @if (isset($video->description))
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round" class="text-muted mb-3">
                                    <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5">
                                    </path>
                                    <rect x="2" y="6" width="14" height="12" rx="2"></rect>
                                </svg>
                                <h4 class="fw-bold text-dark">भिडियो उपलब्ध छैन</h4>
                                <p class="text-muted mb-0">अहिलेसम्म कुनै भिडियो अपलोड गरिएको छैन। कृपया पछि फेरि जाँच
                                    गर्नुहोस्।</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if (method_exists($videos, 'links'))
            <div class="d-flex justify-content-center mt-4">
                {{ $videos->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

    <style>
        .video-section {
            background-color: #f8f9fa;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-video-container {
            background-color: #000;
        }

        /* Custom pagination styling */
        .pagination {
            --bs-pagination-active-bg: #0d6efd;
            --bs-pagination-active-border-color: #0d6efd;
        }
    </style>
</section>
