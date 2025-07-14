<li class="nav-item dropdown-language dropdown me-2 me-xl-0">
    <select id="language-select" class="form-select" wire:change="changeLanguage($event.target.value)"
        aria-label="Language select">
        <option value="ne" {{ app()->getLocale() == 'ne' ? 'selected' : '' }}>नेपाली</option>
        <option value="en" {{ app()->getLocale() == 'en' ? 'selected' : '' }}>English</option>
    </select>
</li>

@script
<script>
    $wire.on('language-change', () => {
        window.location.reload();
    });
</script>
@endscript