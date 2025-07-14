@php
    $fileExtension = strtolower(pathinfo($selectedNotice->file, PATHINFO_EXTENSION));
@endphp

<div
    class="p-6 sm:max-w-full lg:max-w-[1200px] xl:max-w-[1400px] mx-auto flex flex-col lg:flex-row gap-6 h-[100%] justify-between">
    <!-- Main Content Area -->
    <div class="bg-white rounded-lg shadow-xl p-6 flex flex-col gap-6 w-full lg:w-7/12">
        <!-- Back to Notices -->
        <div class="flex justify-between items-center">
            <h3 class="text-sm  lg:text-2xl xl:text-3xl font-bold text-gray-800">{{ $selectedNotice->title }}
            </h3>
            <a href="{{ route('digital-board.notice.show') }}"
                class="text-sm sm:text-base md:text-lg text-gray-600 hover:text-blue-600 flex items-center space-x-2 transition-all">
                <span class="text-sm sm:text-base md:text-lg font-medium">{{ __('Back to all notices->') }}</span>
            </a>
        </div>

        <hr>

        <!-- Notice File (PDF/Image) -->
        <div class="w-full max-w-full flex justify-center">
            @if ($fileExtension === 'pdf')
                <iframe src="{{ asset('storage/digital-board/notices/' . $selectedNotice->file) }}" width="100%"
                    height="400px" class="rounded-lg shadow-lg border-0"></iframe>
            @else
                <div
                    class="flex w-full max-h-[500px] justify-center overflow-hidden rounded-lg shadow-lg bg-cover border-2 border-gray-300">
                    <img src="{{ asset('storage/digital-board/notices/' . $selectedNotice->title) }}" alt="notice"
                        class="w-full h-full object-cover rounded-lg">
                </div>
            @endif
        </div>

        <!-- Notice Description -->
        <div class="text-gray-700 text-lg leading-relaxed mt-4">
            <p>{{ $selectedNotice->description }}</p>
        </div>
    </div>

    <!-- Recently Published Section -->
    <div
        class="bg-gradient-to-r from-blue-50 via-blue-100 to-indigo-100 rounded-lg shadow-xl w-full lg:w-4/12 p-6 flex flex-col max-h-[500px]">
        <h2 class="text-3xl font-semibold text-gray-800 mb-4">{{ __('Recently Published') }}</h2>
        <hr>

        <!-- Set Fixed Height and Allow Scrolling -->
        <div class="space-y-4 overflow-y-auto max-h-[500px] hide-scrollbar-y">
            @foreach ($latestNotices as $latestNotice)
                <div class="flex gap-4 bg-white hover:bg-gray-100 rounded-lg p-4 cursor-pointer transition-all duration-300 shadow-md sm:text-sm sm:px-2"
                    wire:click="showNoticeDetail({{ $latestNotice->id }})">
                    <img src="{{ customAsset(config('src.DigitalBoard.notice.notice_path'), $latestNotice->file) }}"
                        alt="image" class="w-16 h-16 rounded-full shadow-lg">
                    <div class="flex flex-col space-y-1">
                        <p class="text-lg font-medium text-gray-800 hover:text-blue-500">{{ $latestNotice->title }}</p>
                        <p class="text-sm text-gray-500">{{ $latestNotice->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>







{{-- @section('scripts')
    <script>
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
@endsection --}}
