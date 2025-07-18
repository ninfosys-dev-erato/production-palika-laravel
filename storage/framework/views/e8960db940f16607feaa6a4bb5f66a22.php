<header class="header">
    <div class="header-content">
        <!-- Logo Container -->
        <div class="logo-container">
            <a href="<?php echo e(route('customer.home.index')); ?>" aria-label="Go to homepage">
                <img src="<?php echo e(getSetting('palika-logo')); ?>" alt="National Emblem of Nepal" class="primary-logo" />
            </a>
        </div>

        <!-- Text Container -->
        <div class="text-container">
            <h1 class="heading2">
                <a href="<?php echo e(route('customer.home.index')); ?>" class="header-link">
                    <?php echo e(getSetting('palika-name')); ?>

                </a>
            </h1>
            <p class="slogan">

                <?php echo e(getSetting('office-name')); ?>

            </p>
            <p class="slogan">
                <?php echo e(getSetting('palika-province') . ', ' . getSetting('palika-district') . ', ' . 'नेपाल्'); ?>

            </p>
        </div>

        <!-- Secondary Logo Container -->
        <div class="logo-container">
            <img src="<?php echo e(getSetting('palika-campaign-logo')); ?>" alt="<?php echo e(getSetting('palika-name')); ?>"
                class="secondary-logo" />
        </div>
    </div>
    <hr class="header-hr">
</header>
<?php /**PATH /var/www/html/resources/views/home/partials/header.blade.php ENDPATH**/ ?>