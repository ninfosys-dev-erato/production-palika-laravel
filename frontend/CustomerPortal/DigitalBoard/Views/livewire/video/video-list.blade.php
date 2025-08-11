<div
    class="flex flex-col sm:max-w-[800px] lg:max-w-[900px] xl:max-w-[1000px] 2xl:max-w-[1400px] sm:mx-auto mx-2 lg:flex-row gap-4 sm:gap-8 font-inter xl:my-16 md:justify-between">
    <div
        class="flex-row lg:flex-col gap-2 md:w-2/6 py-1 md:py-3 justify-center lg:justify-start items-center lg:items-start lg:py-16 w-full md:w-auto  lg:flex mx-2 md:mx-auto">
        <div class="relative mb-1">
            <div class="flex w-fit px-3 py-2 bg-[#E4F0FF] gap-1 md:gap-2 rounded-lg items-center pr-5 md:pr-auto cursor-pointer"
                wire:click="toggleDropdown">
                <p class="text-[#4E4E4E] text-xs md:text-sm font-bold">
                    {{ $ward }}
                </p>
                <img src="{{ customFileAsset(config('src.DigitalBoard.icons_path'), 'down-arrow.png', 'local', 'tempUrl') }}" alt="down-arrow" class="w-3 md:w-4 w-3 md:h-5">
            </div>

            @if ($isDropdownVisible)
                <div class="absolute top-10 left-0 bg-white shadow-md rounded-md w-full z-10 max-h-64 overflow-y-auto">
                    <ul>
                        <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer" wire:click="showAllVideos">
                            {{ __('All Wards') }}
                        </li>

                        @foreach ($wards as $key => $ward)
                            <li class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                                wire:click="filterWard({{ $ward }})">
                                {{ __('Ward') }} - {{ $ward }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <div class="flex gap-3 w-20 md:w-fit mb-1">
            <div class="col-md-2">
                <label for="start_date" class="form-label">
                    <div
                        class="flex w-fit px-3 py-2 bg-[#E4F0FF] gap-1 md:gap-2 rounded-lg items-center pr-5 md:pr-auto cursor-pointer">
                        <p class="text-[#4E4E4E] text-xs md:text-sm font-bold">{{ __('Start') }}</p>
                        <input type="text" wire:model="start_date" name="start_date" id="start_date"
                            class="nepali-date form-control bg-transparent border-none p-0 focus:ring-0"
                            value="{{ request('start_date') }}" placeholder="{{ __('Date') }}">
                    </div>
                </label>
            </div>
        </div>

        <div class="flex gap-3 w-20 md:w-fit mb-1">
            <div class="col-md-2">
                <label for="end_date" class="form-label">
                    <div
                        class="flex w-fit px-3 py-2 bg-[#E4F0FF] gap-1 md:gap-2 rounded-lg items-center pr-5 md:pr-auto cursor-pointer">
                        <p class="text-[#4E4E4E] text-xs md:text-sm font-bold">{{ __('End') }}</p>
                        <input type="text" wire:model="end_date" name="end_date" id="end_date"
                            class="nepali-date form-control bg-transparent border-none p-0 focus:ring-0"
                            value="{{ request('end_date') }}" placeholder="{{ __('Date') }}">
                    </div>
                </label>
            </div>
        </div>
        <div class="flex w-20 md:w-fit px-3 py-2 gap-1 md:gap-2 rounded-lg items-center pr-5 md:pr-auto cursor-pointer">
            @if ($isFiltered)
                <button wire:click="resetFilter" class="text-xs text-blue-600 ml-2">{{ __('Clear') }}</button>
            @endif

            <button wire:click="filterDate"
                class="bg-[#01399A] px-6 py-2 md:px-9 md:py-2 rounded-md md:rounded-lg text-white text-xs md:font-bold w-fit ml-auto">{{ __('Filter') }}</button>
        </div>

    </div>
    <div class="w-full mx-auto md:w-4/6">
        <div class="flex flex-col">
            <h2 class="text-base lg:text-2xl mx-3 md:mx-0 font-semibold mb-3">{{ __('Videos') }}</h2>
            <div class="md:w-full flex flex-col md:flex-row mx-3 md:mx-0 md:justify-between gap-2 md:gap-6">
                <div class="relative w-full md:w-4/5">
                    <img src="{{ customFileAsset(config('src.DigitalBoard.icons_path'), 'searchh.png', 'local', 'tempUrl') }}" alt="search"
                        class="absolute left-3 w-4 h-4 top-2">
                    <input type="text" wire:model.debounce.300ms="search"
                        class="text-xs border border-[#AEAEAE] rounded-lg py-2 pl-9 pr-10 w-full"
                        placeholder="{{ __('Search') }}">
                    <button type="button"
                        wire:click="resetSearch"class="absolute right-3 top-2 text-gray-500 hover:text-black focus:outline-none">&#x2715;</button>
                </div>
                <button wire:click="searchVideos"
                    class="bg-[#01399A] px-6 py-2 md:px-9 md:py-2 rounded-md md:rounded-lg text-white text-xs md:font-bold w-fit ml-auto">{{ __('Search') }}</button>
            </div>
            <div class="md:mt-8 mx-2 mt-4 grid grid-cols-2 md:grid-cols-3 gap-2 sm:gap-4">
                @foreach ($videos as $video)
                    <a href="{{ route('digital-board.video.showDetail', ['id' => $video->id]) }}">
                        <div
                            class="flex w-full flex-col px-3 py-1 md:py-3 gap-1 md:gap-3 bg-[#F3F3F3] rounded-md md:rounded-xl items-center">
                            <div
                                class="flex justify-center items-center py-1 md:py-1 px-2 md:px-3 w-full bg-[#494949] rounded-xl">
                                <img src="{{ getVideoThumbnail($video) }}" alt="video-logo"
                                    class=" w-16 md:w-24 h-16 md:h-24 object-cover">
                            </div>
                            <div class="space-y-0.5">
                                <p class="text-[#171717] text-sm font-medium leading-tight line-clamp-3">
                                    {{ $video->title }}</p>
                                <p class="text-[#818181] text-xs">
                                    {{ $video->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>

        <div class="flex items-center justify-between mt-4 mx-4">
            <div class="relative">
                <button id="dropdownButton"
                    class="flex items-center px-4 py-2 text-sm bg-white border border-gray-300 rounded shadow-sm focus:outline-none">
                    Rows
                    <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <ul id="dropdownMenu"
                    class="absolute z-10 hidden w-32 mt-1 bg-white border border-gray-300 rounded shadow-md">
                    <li>
                        <button wire:click="$set('perPage', 5)"
                            class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100">
                            5
                        </button>
                    </li>
                    <li>
                        <button wire:click="$set('perPage', 10)"
                            class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100">
                            10
                        </button>
                    </li>
                    <li>
                        <button wire:click="$set('perPage', 15)"
                            class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100">
                            15
                        </button>
                    </li>
                    <li>
                        <button wire:click="$set('perPage', 20)"
                            class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100">
                            20
                        </button>
                    </li>
                </ul>
            </div>

            <!-- Pagination -->
            <nav class="flex items-center space-x-2">
                @if ($videos->onFirstPage())
                    <span
                        class="px-3 py-1 text-sm text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        &lt;
                    </span>
                @else
                    <button wire:click="previousPage"
                        class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100">
                        &lt;
                    </button>
                @endif

                @foreach ($videos->links()->elements[0] as $page => $url)
                    @if ($page == $videos->currentPage())
                        <span class="px-3 py-1 text-sm text-white rounded"
                            style="background-color: #01399A; border: 1px solid #01399A;">
                            {{ $page }}
                        </span>
                    @else
                        <button wire:click="gotoPage({{ $page }})"
                            class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100">
                            {{ $page }}
                        </button>
                    @endif
                @endforeach

                <!-- Next Page Link -->
                @if ($videos->hasMorePages())
                    <button wire:click="nextPage"
                        class="px-3 py-1 text-sm bg-white border border-gray-300 rounded hover:bg-gray-100">
                        &gt;
                    </button>
                @else
                    <span
                        class="px-3 py-1 text-sm text-gray-400 bg-gray-100 border border-gray-300 rounded cursor-not-allowed">
                        &gt;
                    </span>
                @endif
            </nav>
        </div>
    </div>
</div>

@script
    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', (event) => {
            event.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });
        document.addEventListener('click', (event) => {
            if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
@endscript
