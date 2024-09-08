<x-front-layout>
    <section class="sub-page-banner">
        @if ($image = $pageData->getFirstMedia('banner_image'))
            <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
                class="full-image" />
        @endif
        <div class="container">
            @if ($content = $pageData->get('banner_content'))
                <div class="content-wrapper">{!! $content !!}</div>
            @endif
        </div>
    </section>

    @if ($postCategories->isNotEmpty())
        <section class="post-listing">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="row">
                            @foreach ($postCategories as $postCategory)
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    @include('front.post.category.item')
                                </div>
                            @endforeach
                        </div>

                        {!! $posts->appends(request()->input())->links() !!}
                    </div>

                    <div class="col-lg-4">
                        @include('front.post.aside')
                    </div>
                </div>
            </div>

            {!! $postCategories->appends(request()->input())->links() !!}
        </section>
    @else
        <section class="post-notfound">
            <div class="container">
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation"></i>
                    <p>{{ __('No Resources Found') }}</p>
                </div>
            </div>
        </section>
    @endif

</x-front-layout>
