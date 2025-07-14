<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ getSetting('palika-name') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#2A5CA4',
                        component: '#eef1f8',
                        status: '#7D7D7D',
                    },
                    fontFamily: {
                        inter: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 ">
    <!-- Header -->
    <header class="bg-background text-white font-inter">
        <div
            class="sm:max-w-[800px] lg:max-w-[900px] xl:max-w-[1000px] 2xl:max-w-[1400px] sm:mx-auto mx-2 flex items-center justify-between py-2 sm:py-4">
            <a href="{{ route('customer.home.index') }}" class="flex flex-row gap-1 sm:gap-3">
                <img src="{{ asset('assets/img/avatars/Emblem_of_Nepal.svg.png') }}" alt="logo"
                    class="sm:w-[50px] sm:h-[50px] h-[35px] w-[43.33px]">
                <div class="flex flex-col">
                    <h1 class="leading-tight font-semibold">
                        <span class="text-[14px] sm:text-[24px] ">
                            {{ getSetting('palika-name') }}
                        </span>
                    </h1>
                    <span class="text-[10px] sm:text-[14px] block">
                        {{ getSetting('palika-province') }}, {{ getSetting('palika-district') }}
                </div>
            </a>
            <div class="flex flex-col sm:flex-row gap-2 items-center space-x-4">
                <div class="relative w-full max-w-48 hidden xl:block">
                    <!-- Search Icon -->
                    <img src="{{ asset('digitalBoard/icons/Search.png') }}" alt="search"
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 h-[20px] w-[20px]" />
                    <!-- Input Field -->
                    <input type="text" placeholder="{{ __('Search') }}"
                        class="pl-10 w-[200px] sm:w-full pr-4 py-2 rounded-[10px] text-[#FFFFFF] border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" />
                </div>

                <!-- Go to Services -->
                <div
                    class="w-fit bg-blue-500 rounded-[5px] sm:rounded-[10px] py-1 sm:px-2 bg-gradient-to-r from-[rgba(67,33,151,0.55)] to-[#103268] hover:bg-blue-600 transition flex items-center px-2 md:px-4">
                    <a href="{{ route('digital-service') }}" class="flex items-center gap-1 sm:gap-2">
                        <button class="text-white placeholder-gray-300 text-[10px] sm:text-[14px] font-medium">
                            {{ __('Go to Services') }}
                        </button>
                        <img src="{{ asset('digitalBoard/icons/arrowRight.png') }}" alt="right arrow"
                            class="h-[12px] sm:h-[16px] sm:w-[24px]" />
                    </a>
                </div>


                <!-- Toggle switch -->
                <button
                    class="w-7 md:w-12 xl:w-16 h-3 md:h-5 xl:h-7 hidden sm:flex rounded-full bg-white items-center transition duration-300 focus:outline-none shadow"
                    onclick="toggleLanguage()">
                    <div id="switch-toggle"
                        class="w-7 xl:w-10 h-7 xl:h-10 relative rounded-full transition duration-500 transform bg-slate-700 -translate-x-1 p-1 text-white flex justify-center items-center">
                    </div>
                </button>

            </div>
        </div>
    </header>

    <script>
        const switchToggle = document.querySelector('#switch-toggle');
        let isEn = localStorage.getItem('isEn') === 'true'; // Retrieve from localStorage
        const en = 'EN';
        const ne = 'ने';

        function toggleLanguage() {
            isEn = !isEn;
            localStorage.setItem('isEn', isEn);
            switchTheme();
            updateLanguage(isEn ? 'en' : 'ne');
        }

        function switchTheme() {
            if (isEn) {
                switchToggle.classList.add('translate-x-full');
                setTimeout(() => {
                    switchToggle.innerHTML = en;
                }, 250);
            } else {
                switchToggle.classList.remove('translate-x-full');
                setTimeout(() => {
                    switchToggle.innerHTML = ne;
                }, 250);
            }
        }

        function updateLanguage(language) {
            fetch('/change-language', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        language: language
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    location.reload();
                })
                .catch((error) => console.error('Error updating language:', error));
        }
        document.addEventListener('DOMContentLoaded', () => {
            switchTheme();
        });
    </script>

</body>

</html>
