<div class="flex flex-col sm:max-w-[800px] lg:max-w-[900px] xl:max-w-[1000px] 2xl:max-w-[1400px] sm:mx-auto mx-2 lg:flex-row gap-8 md:gap-16 font-inter sm:my-16">
    <div class="flex flex-col w-full md:w-4/6 justify-center md:justify-start md:my-12">
        <a href="{{ route('digital-board.video.show') }}">
            <div class="flex gap-1 text-[#7E7E7E] items-center mt-9 md:mt-0 md:gap-3 mx-2 md:mx-0">
                <img src="{{ asset('digitalBoard/icons/left-arrow (1).png') }}" alt=""
                    class="w-2 md:w-3 h-2 md:h-3">
                <p class="text-[10px] md:text-[15px]">{{ __('Back to all videos') }}</p>
            </div>
        </a>
        <div class="my-2 md:my-4 gap-3 mx-2 md:mx-0">
            <p class="text-base lg:text-2xl text-[#282828] mb-1 md:mb-2 leading-tight">{{ $selectedVideo->title }}
            </p>
            <hr class="w-full h-2">
        </div>
        <div class="flex flex-col gap-1 md:gap-3 mx-2 md:mx-0">
            <div class="flex bg-slate-100 md:h-[270px] bg-cover w-full overflow-hidden rounded-sm">
                @if ($selectedVideo->file)
                    <iframe
                        src="{{ customVideoAsset(config('src.DigitalBoard.video.video_path'), $selectedVideo->file) }}"
                        frameborder="0" class="w-full h-auto rounded-sm" sandbox="allow-scripts allow-same-origin"
                        loading="lazy" allow="fullscreen; geolocation" referrerpolicy="no-referrer">
                    </iframe>
                @elseif ($selectedVideo->url)
                    <iframe src="https://www.youtube.com/embed/{{ Str::afterLast($selectedVideo->url, '=') }}"
                        frameborder="0" class="w-full h-auto rounded-sm" sandbox="allow-scripts allow-same-origin"
                        loading="lazy" allow="fullscreen; geolocation" referrerpolicy="no-referrer">
                    </iframe>
                @else
                    <p>No video available.</p>
                @endif
            </div>

            <div class="ml-auto flex gap-1 md:gap-2 items-center">
                <img src="{{ asset('digitalBoard/icons/clock.png') }}" alt="date-time" class="w-3 md:w-4 h-3 md:h-4">
                <p class="text-[#818181] text-xs font-semibold">
                    {{ $selectedVideo->created_at->diffForHumans() }}
                </p>
            </div>
        </div>


    </div>
    <div class="w-full md:w-2/6 py-5 bg-[#EEF1F8] md:my-12 rounded-lg px-6 max-h-min">
        <p class="text-base lg:text-xl font-semibold mb-4">{{ __('Recent Videos') }}</p>
        <div class="flex flex-col max-h-[360px] hide-scrollbar-y overflow-y-auto gap-2 md:gap-3">
            @foreach ($latestVideos as $latestVideo)
                <button
                    class="w-full text-left rounded-xl text-base cursor-pointer
                        flex justify-between items-center transition-all duration-300 accordion-button
                        {{ $latestVideo->id == $selectedVideo->id ? 'bg-blue-100' : 'bg-[#F9F9F9] hover:bg-blue-100' }}">
                    <div class="flex items-center gap-3 bg-white rounded-lg px-4 py-3 cursor-pointer"
                        wire:click="showVideoDetail({{ $latestVideo->id }})">

                        <img src="{{ getVideoThumbnail($latestVideo) }}" alt="thumbnail"
                            class="w-32 h-12 object-cover rounded-md">
                        <div class="space-y-0.5">
                            <p class="text-[#444444] text-base underline leading-0.5">{{ $latestVideo->title }}</p>
                            <p class="text-[10px] text-[#818181]">{{ $latestVideo->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
</div>

@section('scripts')
    <script>
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
                style.innerHTML = `
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
    </script>
@endsection
