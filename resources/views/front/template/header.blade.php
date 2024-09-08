<header class="main-header">
    <div class="container">
        <div class="logo-wrapper">
            <a href="{{ route(FrontPageRoutePath::HOME) }}">
                <img src="{{ settings(SettingModule::GENERAL)->getFirstMedia('site_logo')?->getFullUrl() }}"
                    class="logo">
                <script>
                    const SITE_LOGO = '{{ settings(SettingModule::GENERAL)->getFirstMedia('logo')?->getFullUrl() }}';
                </script>
            </a>
        </div>
        <div class="right">
            <div class="menu-wrapper">
                <div id="primaryNav">
                    <ul>
                        <li><a href="{{ route(FrontPageRoutePath::HOME) }}">Home</a></li>
                        <li><a href="{{ route(FrontPostRoutePath::INDEX) }}">Blog</a></li>
                        <li><a href="{{ route(FrontPageRoutePath::CONTACT) }}">Contact</a></li>
                    </ul>
                </div>
            </div>

            @include('front.partials.social-media')

            <a href="{{ route(FrontPageRoutePath::INQUIRY) }}" class="plan-link">Inquiry</a>
        </div>

        <a href="#primaryNav" class="menu-icon"><i class="fa-solid fa-bars"></i></a>
    </div>
</header>
