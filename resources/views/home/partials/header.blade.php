<header class="header">
    <div class="header-content">
        <!-- Logo Container -->
        <div class="logo-container">
            <a href="{{ route('customer.home.index') }}" aria-label="Go to homepage">
                <img src="{{ getSetting('palika-logo') }}" alt="National Emblem of Nepal" class="primary-logo" />
            </a>
        </div>

        <!-- Text Container -->
        <div class="text-container">
            <h1 class="heading2">
                <a href="{{ route('customer.home.index') }}" class="header-link">
                    {{ getSetting('palika-name') }}
                </a>
            </h1>
            <p class="slogan">

                {{ getSetting('office-name') }}
            </p>
            <p class="slogan">
                {{ getSetting('palika-province') . ', ' . getSetting('palika-district') . ', ' . 'नेपाल्' }}
            </p>
        </div>

        <!-- Secondary Logo Container -->
        <div class="logo-container">
            <img src="{{ getSetting('palika-campaign-logo') }}" alt="{{ getSetting('palika-name') }}"
                class="secondary-logo" />
        </div>
    </div>
    <hr class="header-hr">
</header>
