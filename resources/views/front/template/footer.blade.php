<footer class="main-footer">
    @if ($image = settings(SettingModule::GENERAL)->getFirstMedia('footer_background'))
        <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
            class="footer-bg" />
    @endif

    @if ($image = settings(SettingModule::GENERAL)->getFirstMedia('footer_logo'))
        <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
            class="overlay-logo" />
    @endif

    <div class="container">
        <div class="top">
            @if ($image = settings(SettingModule::GENERAL)->getFirstMedia('footer_logo'))
                <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
                    class="logo" />
            @endif

            @if ($content = settings(SettingModule::GENERAL)->get('footer_content'))
                {!! $content !!}
            @endif
        </div>
        <div class="middle">
            <div class="left">
                @if ($title = settings(SettingModule::GENERAL)?->get('footer_contact'))
                    <p>
                        {!! nl2br($title) !!}
                        <br>
                        @if ($phone = settings(SettingModule::GENERAL)?->get('contact_phone'))
                            <a href="tel:{{ $phone }}">{{ $phone }}</a>
                        @endif
                    </p>
                @endif
                @include('front.partials.social-media')
            </div>
            <div class="right">
                @if ($menu = settings(SettingModule::GENERAL)->get('footer_menu_one'))
                    <div class="item">
                        @if ($title = settings(SettingModule::GENERAL)->get('footer_menu_one_title'))
                            <h4>{{ $title }}</h4>
                        @endif
                        <ul>
                            @foreach ($menu as $link)
                                <li>
                                    <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($menu = settings(SettingModule::GENERAL)->get('footer_menu_two'))
                    <div class="item">
                        @if ($title = settings(SettingModule::GENERAL)->get('footer_menu_two_title'))
                            <h4>{{ $title }}</h4>
                        @endif
                        <ul>
                            @foreach ($menu as $link)
                                <li>
                                    <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($menu = settings(SettingModule::GENERAL)->get('footer_menu_three'))
                    <div class="item">
                        @if ($title = settings(SettingModule::GENERAL)->get('footer_menu_three_title'))
                            <h4>{{ $title }}</h4>
                        @endif
                        <ul>
                            @foreach ($menu as $link)
                                <li>
                                    <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if ($menu = settings(SettingModule::GENERAL)->get('footer_menu_four'))
                    <div class="item">
                        @if ($title = settings(SettingModule::GENERAL)->get('footer_menu_four_title'))
                            <h4>{{ $title }}</h4>
                        @endif
                        <ul>
                            @foreach ($menu as $link)
                                <li>
                                    <a href="{{ $link['url'] }}">{{ $link['title'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="bottom">
            <p class="copyrights">All rights reserved {{ date('Y') }}</p>
        </div>
    </div>
</footer>
