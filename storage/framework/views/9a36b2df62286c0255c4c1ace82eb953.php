<h3 class="employee-heading"><?php echo e(getSetting('palika-type')); ?>को प्रतिनिधिहरु तथा कर्मचारीहरु</h3>
<hr class="mb-2">
<div class="flex flex-col w-[98%] md:flex-row gap-y-8 md:gap-4 justify-around md:h-[300px] px-4 md:px-0">

    <!-- Representatives Section -->
    <div class="bg-gray-100 rounded-lg shadow-md p-3 md:p-4 h-full w-full md:w-1/2 flex flex-col">

        <div class="items-center mb-3 md:mb-4">
            <p class="text-lg md:text-xl text-dark font-medium">हाम्रा प्रतिनिधिहरू</p>
            <hr>
        </div>

        <!-- Representatives Slider Container -->
        <div class="flex-1 overflow-hidden relative">
            <div id="representativeSliderWrapper" class="overflow-hidden relative w-full">
                <div id="representativeSlider"
                    class="flex gap-4 md:gap-5 no-scrollbar transition-transform duration-700 ease-in-out">
                    <?php $__currentLoopData = $representatives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $representative): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="flex-none w-[calc(50%-16px)] sm:w-[calc(33.33%-16px)] min-w-[150px] md:min-w-[180px]">
                            <div class="flex flex-col gap-2 md:gap-3">
                                <div class="rounded-lg overflow-hidden h-32 md:h-40 relative group">
                                    <img src="<?php echo e(customAsset(config('src.Employees.employee.photo_path'), $representative->photo)); ?>"
                                        alt="<?php echo e($representative->title); ?>"
                                        class="w-full h-full object-contain transform transition-transform duration-300 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>

                                <div class="px-1 text-center leading-tight">
                                    <p class="text-dark  text-sm sm:text-base font-semibold truncate">
                                        <?php echo e($representative->name); ?></p>
                                    <span class="text-status text-[13px] ">
                                        <?php echo e($representative->designation->title ?? 'No Designation'); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Employees Section -->
    <div class="bg-gray-100 rounded-lg shadow-md p-3 md:p-4 h-full w-full md:w-1/2 flex flex-col">


        <!-- Employees Slider Container -->
        <div class="flex-1 overflow-hidden relative">
            <div class="mb-3 md:mb-4">
                <p class="text-lg md:text-xl text-dark font-medium">हाम्रो कर्मचारी</p>
                <hr>
            </div>
            <div id="employeeSliderWrapper" class="overflow-hidden relative w-full">
                <div id="employeeSlider"
                    class="flex gap-4 md:gap-5 no-scrollbar transition-transform duration-700 ease-in-out">
                    <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div
                            class="flex-none w-[calc(50%-16px)] sm:w-[calc(33.33%-16px)] min-w-[150px] md:min-w-[180px]">
                            <div class="flex flex-col gap-2 md:gap-3">
                                <div class="rounded-lg overflow-hidden h-32 md:h-40 relative group">
                                    <img src="<?php echo e(customAsset(config('src.Employees.employee.photo_path'), $employee->photo)); ?>"
                                        alt="<?php echo e($employee->name); ?>"
                                        class="w-full h-full object-contain transform transition-transform duration-300 group-hover:scale-105">
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </div>
                                <div class="px-1 text-center leading-tight">
                                    <p class="text-dark text-sm sm:text-base font-semibold truncate ">
                                        <?php echo e($employee->name); ?></p>
                                    <span class="text-status text-[13px] ">
                                        <?php echo e($employee->designation->title ?? 'No Designation'); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </div>
    </div>


</div>



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


<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize all sliders with proper configuration
        initSliderPair('videoSlider', 'programSlider');
        initSliderPair('employeeSlider', 'representativeSlider');
    });

    function initSliderPair(sliderId1, sliderId2) {
        const slider1 = initSingleSlider(sliderId1);
        const slider2 = initSingleSlider(sliderId2);
        let activeSlider = slider1;

        // Alternate between sliders every 3 seconds
        setInterval(() => {
            activeSlider = activeSlider === slider1 ? slider2 : slider1;
            activeSlider.nextSlide();
        }, 3000);
    }

    function initSingleSlider(sliderId) {
        const slider = document.getElementById(sliderId);
        if (!slider) return null;

        const container = slider.parentElement;
        const slides = slider.children;
        if (slides.length === 0) return null;

        // Calculate real gap and slide width
        const gap = parseInt(window.getComputedStyle(slider).gap) || 0;
        let slideWidth = slides[0].offsetWidth + gap;

        // Clone slides for seamless transition
        slider.innerHTML += slider.innerHTML;

        let currentIndex = 0;
        let isTransitioning = false;

        function nextSlide() {
            if (isTransitioning) return;
            isTransitioning = true;

            currentIndex++;
            slider.style.transition = 'transform 0.7s ease-in-out';
            slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

            // Reset position when reaching cloned set
            if (currentIndex >= slides.length / 2) {
                setTimeout(() => {
                    slider.style.transition = 'none';
                    slider.style.transform = 'translateX(0)';
                    currentIndex = 0;
                    isTransitioning = false;
                }, 700);
            } else {
                setTimeout(() => isTransitioning = false, 700);
            }
        }

        // Handle window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                slideWidth = slides[0].offsetWidth + gap;
            }, 250);
        });

        // Pause on hover
        container.addEventListener('mouseenter', () => isTransitioning = true);
        container.addEventListener('mouseleave', () => isTransitioning = false);

        return {
            nextSlide
        };
    }
</script><?php /**PATH /var/www/html/resources/views/components/employee-section-component.blade.php ENDPATH**/ ?>