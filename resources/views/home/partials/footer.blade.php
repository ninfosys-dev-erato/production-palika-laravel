<!-- Footer Section -->
<footer class="footer">
    <div class="footer-container">
        <p>&copy; {{ getSetting('year') }} डिजिटल {{ getSetting('palika-name') }}</p>

        <div class="footer-contact">
            <p>
                <strong>{{ getSetting('engineer-name') }}:</strong>
                <a href="tel:{{ getSetting('engineer-phone-number') }}">{{ getSetting('engineer-phone-number') }}</a> |
                <a href="mailto:{{ getSetting('engineer-email') }}">{{ getSetting('engineer-email') }}</a>
            </p>
            <p>
                <strong>सम्पर्क:</strong>
                <a href="tel:{{ getSetting('office_phone') }}">{{ getSetting('office_phone') }}</a> |
                <a href="mailto:{{ getSetting('office_email') }}">{{ getSetting('office_email') }}</a>
            </p>
        </div>
    </div>
</footer>
