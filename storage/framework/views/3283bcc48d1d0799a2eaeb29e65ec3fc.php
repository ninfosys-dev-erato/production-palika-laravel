<!-- Footer Section -->
<footer class="footer">
    <div class="footer-container">
        <p>&copy; <?php echo e(getSetting('year')); ?> डिजिटल <?php echo e(getSetting('palika-name')); ?></p>

        <div class="footer-contact">
            <p>
                <strong><?php echo e(getSetting('engineer-name')); ?>:</strong>
                <a href="tel:<?php echo e(getSetting('engineer-phone-number')); ?>"><?php echo e(getSetting('engineer-phone-number')); ?></a> |
                <a href="mailto:<?php echo e(getSetting('engineer-email')); ?>"><?php echo e(getSetting('engineer-email')); ?></a>
            </p>
            <p>
                <strong>सम्पर्क:</strong>
                <a href="tel:<?php echo e(getSetting('office_phone')); ?>"><?php echo e(getSetting('office_phone')); ?></a> |
                <a href="mailto:<?php echo e(getSetting('office_email')); ?>"><?php echo e(getSetting('office_email')); ?></a>
            </p>
        </div>
    </div>
</footer>
<?php /**PATH /var/www/html/resources/views/home/partials/footer.blade.php ENDPATH**/ ?>