@extends('digitalBoard.layout')
@section('content')
    <div class="main my-[32px]">
        <div
            class="flex flex-col sm:max-w-[800px] lg:max-w-[900px] xl:max-w-[1000px] 2xl:max-w-[1400px] sm:mx-auto mx-2 lg:flex-row gap-0 sm:gap-8 font-inter my-6 sm:my-16 md:justify-between">
            <div class="flex flex-col w-full gap-7 md:gap-16 md:mx-56">
                <div class="mx-3 md:mx-12">
                    <p class="text-base lg:text-2xl text-[#3E3E3E] mx-3 md:mx-0">{{ __('Employee') }}</p>
                    <div class="md:w-full flex flex-col md:flex-row mx-3 md:mx-0 md:justify-between gap-2 md:gap-20">
                        <form id="search-form" action="{{ route('digital-board.searchEmployees') }}" method="GET"
                            class="w-full flex items-center gap-2">
                            <div class="relative w-full mt-1">
                                <img src="{{ asset('digitalBoard/icons/searchh.png') }}" alt="search"
                                    class="absolute left-3 w-4 h-4 top-2">
                                <input type="text" id="search-input" name="query"
                                    class="text-xs border border-[#AEAEAE] rounded-lg py-2 pl-9 pr-10 w-full"
                                    placeholder="खोज्नुहोस" value="{{ request('query') }}">
                                <button type="button" id="clear-search" 
                                    class="absolute right-3 top-2 text-gray-500 hover:text-black focus:outline-none">
                                    &#x2715;
                                </button>
                            </div>
                            <button type="submit"
                                class="bg-[#01399A] px-6 py-2 md:px-9 md:py-2 rounded-md md:rounded-lg text-white text-xs md:font-bold w-fit ml-auto">
                                {{ __('Search') }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="grid grid-cols-3 gap-x-3 gap-y-3 md:gap-x-4 md:gap-y-12 mx-5">
                    @foreach ($employees as $employee)
                        <div class="bg-[#F3F3F3] py-2 px-2 rounded-md flex items-center flex-col gap-4">
                            <div class="bg-[#ECEAEA] rounded-lg py-3 px-4">

                                <img src="{{ customFileAsset(config('src.Employees.employee.photo_path'), $employee->photo, 'local', 'tempUrl') }}"
                                    alt="{{ $employee->name }}" class="h-16 md:h-24 w-12 md:w-20">
                            </div>
                            <div class="flex flex-col items-center gap-0">
                                <p class="text-[11px] md:text-[17px] ">
                                    {{ $employee->name }}
                                </p>
                                <p class="text-[#818181] text-[10px] md:text-[15px]">
                                    {{ $employee->designation->title ?? 'No Designation' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('search-input');
            const clearSearch = document.getElementById('clear-search');
            const searchForm = document.getElementById('search-form');

            clearSearch.addEventListener('click', function (e) {
                e.preventDefault(); 
                searchInput.value = '';
                searchForm.submit(); 
            });
        });
    </script>
@endsection
