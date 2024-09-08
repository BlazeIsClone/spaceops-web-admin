<x-front-layout>
    <section class="sub-page-banner">
        @if ($post->getFirstMedia('featured_image'))
            <img src="{{ $post->getFirstMedia('featured_image')?->getFullUrl() }}" alt="{{ $post->name }}"
                class="full-image">
        @endif
        <div class="container">
            <div class="content-wrapper">
                <h1>{{ $post->title }}</h1>
                <p>{{ $post->short_description }}</p>
            </div>
        </div>
    </section>

    <section class="post-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    @if ($post->categories->isNotEmpty())
                        <section class="post-tags">
                            <div class="container">
                                <div class="inner-wrapper">
                                    @if ($post->categories->isNotEmpty())
                                        <div class="item-wrapper categories">
                                            <h3>Categories</h3>
                                            <div class="tag-wrapper">
                                                @if ($categories = $post->categories)
                                                    @foreach ($categories as $category)
                                                        <a class="tag" href="{{ $category->url }}">
                                                            <span>{{ $category->name }}</span>
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </section>
                    @endif

                    @if ($content = $post->description)
                        <section class="post-content">
                            <div class="container">
                                <div class="content-wrapper default">{!! $content !!}</div>
                            </div>
                        </section>
                    @endif

                    @if ($post->getMedia('gallery')->isNotEmpty())
                        <section class="post-gallery gallery">
                            <div class="container">
                                <div class="content-wrapper">
                                    <h2>Gallery</h2>
                                </div>
                                <div class="row">
                                    @if ($gallery = $post->getMedia('gallery'))
                                        @foreach ($gallery as $image)
                                            <div class="col-xs-12 col-sm-6 col-lg-3">
                                                <div class="full-image-parent">
                                                    <img src="{{ $image?->getFullUrl() }}" alt="{{ $post->name }}"
                                                        class="image full-image">
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </section>
                    @endif
                </div>

                <div class="col-lg-4">
                    @include('front.post.aside')
                </div>
            </div>
        </div>
    </section>

    @push('header')
        <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    @endpush
</x-front-layout>
