<div class="d-flex h-100 w-100 pt-3 program-container" wire:poll.5s>
    <div class="d-flex h-100 flex-column " style="width: 25%;">
        <a wire:click="goBack" class="text-decoration-none text-dark  mb-2" style="cursor: pointer;">
            <div class="d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                    <path d="M21 11H6.414l5.293-5.293-1.414-1.414L2.586 12l7.707 7.707 1.414-1.414L6.414 13H21z">
                    </path>
                </svg>
                <p class="fw-medium fs-6 m-0 ms-1">फिर्ता</p>
            </div>
        </a>
        <div class="w-100 d-flex justify-content-between align-items-center rounded-2 px-2 py-1 text-light mt-2"
            style="background-color: var(--secondary)">
            <div class="d-flex align-items-center">
                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-2"
                    style="height: 1.2rem; width: 1.2rem;">
                    <span class="text-primary" style="font-size: 0.8rem">३
                    </span>
                </div>
                <p class="m-0" style="font-size: 0.8rem">मिडियाहरु</p>
            </div>
        </div>

        <div style="overflow-y:auto; height: 90%;" wire:poll.5s>
            @foreach ($videos as $key => $video)
                <div wire:click="showVideoDetail({{ $video->id }})" wire:key="video-{{ $video->id }}"
                    class="w-100 rounded-2 px-2 py-1 mt-2 d-flex cursor-pointer shadow-sm video-item {{ $selectedVideo->id === $video->id ? 'active' : '' }}"
                    data-video-id="{{$key}}" style="cursor: pointer">
                    <div class="video-thumbnail me-2" style="width: 4rem; height: 3rem;">
                        <img src="{{ $video->thumbnail ?? $video->file }}" alt="video thumbnail"
                            class="w-100 h-100 rounded-1 object-fit-cover">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <p class="m-0" style="font-size: 0.8rem">{{$video->title}}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="h-100 pb-3 d-flex flex-column ms-3" style="width: 75%">
        <p id="videoTitle" class="m-0 mb-2 d-flex justify-content-center fw-medium" style="color: var(--primary)">
            {{$selectedVideo->title}}
        </p>
        <div class="rounded-1 overflow-hidden ms-2" style="height: 90%">
            @if ($selectedVideo->file)
                <iframe src="{{ customVideoAsset(config('src.DigitalBoard.video.video_path'), $selectedVideo->file) }}"
                    frameborder="0" class="w-100 " style="min-height: 50vh;" allow="autoplay; fullscreen; geolocation"
                    referrerpolicy="no-referrer" autoplay>
                </iframe>
            @elseif ($selectedVideo->url)
                <iframe src="https://www.youtube.com/embed/{{ Str::afterLast($selectedVideo->url, '=') }}?autoplay=1"
                    frameborder="0" class="w-100" style="min-height: 50vh;" sandbox="allow-scripts allow-same-origin"
                    loading="lazy" allow="autoplay; fullscreen; geolocation" referrerpolicy="no-referrer">
                </iframe>
            @else
                <div class="w-100 h-100 d-flex justify-content-center align-items-center">
                    <div class="alert alert-info" style="width:70%" role="alert">
                        <h5 class="fw-bold text-center">भिडियो उपलब्ध छैन</h5>
                        <p class="m-0 text-center">अहिलेसम्म कुनै भिडियो अपलोड गरिएको छैन। कृपया पछि फेरि जाँच गर्नुहोस्।
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <style>
        .video-item {
            background-color: #fff;
            transition: all 0.3s ease;
        }

        .video-item:hover {
            background-color: rgba(var(--bs-primary-rgb), 0.1);
        }

        .video-item.active {
            background-color: var(--primary) !important;
        }

        .video-item.active p {
            color: #fff !important;
        }

        .video-thumbnail {
            flex-shrink: 0;
        }
    </style>
</div>