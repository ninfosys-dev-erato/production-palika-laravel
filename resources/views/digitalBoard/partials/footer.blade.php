<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Design</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#01399A',
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

<body>

    <!-- Footer -->

    <footer class="mx-auto px-4 pb-3 w-full bg-background text-white">
        <!-- Bottom Section -->
        <div class="border-t border-gray-700 mt-6 pt-6 text-center text-white-400 text-sm">
            <p>&copy; {{ getSetting('year') }} All Rights Reserved.</p>
            <p><a href="{{ route('pages', ['slug' => 'privacy-policy']) }}" class="hover:text-gray-300">Terms of Use
                    & Privacy Policy</a></p>
            <p>Designed and developed by <a href="#" class="hover:text-gray-300">Ninja Infosys</a></p>
        </div>
    </footer>


</body>

</html>
