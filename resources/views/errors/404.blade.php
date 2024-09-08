<x-front-layout>
    <section class="sub-page-banner not-found"></section>

    <section class="page-not-found">
        <div class="container">
            <div class="theme-card">
                <div class="card-body">
                    <div class="content-wrapper">
                        <h1>{{ __('404') }}</h1>
                        <h2>{{ __('Page not found') }}</h2>
                        <p>{{ __('The page you are looking for does not exist.') }}</p>
                        <a href="{{ url('') }}" class="theme-btn">
                            {{ __('Return Home') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-front-layout>
