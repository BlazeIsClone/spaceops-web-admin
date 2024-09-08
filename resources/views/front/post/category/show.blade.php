<x-front-layout>
    <section class="sub-page-banner">
        @if ($postCategory->getFirstMedia('featured_image'))
            <img src="{{ $postCategory->getFirstMedia('featured_image')?->getFullUrl() }}" alt="{{ $postCategory->name }}"
                class="full-image">
        @endif
        <div class="container">
            <div class="content-wrapper">
                <h1>{{ $postCategory->title }}</h1>
            </div>
        </div>
    </section>

    @if ($content = $postCategory->description)
        <section class="post-content">
            <div class="container">
                <div class="content-wrapper default">{!! $content !!}</div>
            </div>
        </section>
    @endif

    @push('header')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    @endpush
</x-front-layout>
