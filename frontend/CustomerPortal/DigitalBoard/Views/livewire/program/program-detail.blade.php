<div class="flex flex-col sm:max-w-[800px] lg:max-w-[900px] xl:max-w-[1000px] 2xl:max-w-[1400px] sm:mx-auto mx-2 lg:flex-row gap-8 md:gap-16 font-inter sm:my-16">
    <div class="flex flex-col w-full md:w-4/6 justify-center md:justify-start md:my-12">

        <a href="{{ route('digital-board.program.show') }}">
            <div class="flex gap-1 text-[#7E7E7E] items-center mt-9 md:mt-0 md:gap-3 mx-2 md:mx-0">
                <img src="{{ customFileAsset(config('src.DigitalBoard.icons_path'), 'left-arrow (1).png', 'local', 'tempUrl') }}" alt=""
                    class="w-2 md:w-3 h-2 md:h-3">
                <p class="text-[10px] md:text-[15px]">{{ __('Back to all programs') }}</p>
            </div>
        </a>
        <div class="my-2 md:my-4 gap-3 mx-2 md:mx-0">
            <p class="text-base lg:text-2xl text-[#282828] mb-1 md:mb-2 leading-tight">{{ $selectedProgram->title }}
            </p>
            <hr class="w-full h-2">
        </div>
        <div class="flex flex-col gap-1 md:gap-3 mx-12 md:mx-40">
            <div class="flex rounded-2xl w-full max-h-[400px] md:max-h-[600px] bg-cover border border-background">
                <img src="{{ customFileAsset(config('src.DigitalBoard.program.photo_path'), $selectedProgram->photo, 'local', 'tempUrl') }}"
                    alt="notices" class="w-full h-full">
            </div>
        </div>
    </div>
    <div class="w-full md:w-2/6 py-5 bg-[#EEF1F8] md:my-12 rounded-lg px-6 max-h-min">
        <p class="text-base lg:text-xl font-semibold mb-4">{{ __('Recent Programs') }}</p>
        <div class="flex flex-col max-h-[360px] hide-scrollbar-y overflow-y-auto gap-2 md:gap-3">
            @foreach ($latestPrograms as $latestProgram)
                <button
                    class="w-full text-left rounded-xl text-[14px] md:text-[17px] cursor-pointer 
                flex justify-between items-center transition-all duration-300 accordion-button
                {{ $latestProgram->id == $selectedProgram->id ? 'bg-blue-100' : 'bg-[#F9F9F9] hover:bg-blue-100' }}">
                    <div class="flex items-center gap-3 bg-white rounded-lg px-4 py-3 cursor-pointer"
                        wire:click="showProgramDetail({{ $latestProgram->id }})">

                        <img src="{{ customFileAsset(config('src.DigitalBoard.program.photo_path'), $latestProgram->photo, 'local', 'tempUrl') }}"
                            alt="{{ $latestProgram->title }}" class="w-32 h-10">
                        <div class="space-y-1">
                            <p class="text-[#444444] text-[14px] underline">{{ $latestProgram->title }}</p>
                            <p class="text-[10px] text-[#818181]">{{ $latestProgram->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <button>
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
