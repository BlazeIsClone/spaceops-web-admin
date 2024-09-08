<div class="post-item">
    <div class="top">
        <div class="image">
            @if ($post->getFirstMedia('listing_image') || $post->getFirstMedia('featured_image'))
                <img src="{{ $post->getFirstMedia('listing_image')?->getFullUrl() ?: $post->getFirstMedia('featured_image')?->getFullUrl() }}"
                    alt="{{ $post->name }}" class="full-image">
            @endif
        </div>
        <h4>{{ $post->name }}</h4>
        <h5>{{ $post->readableDate }}</h5>
        <p>{{ $post->short_description }}</p>
    </div>
    <a href="{{ $post->url }}" class="theme-btn">Read More</a>
    <a href="{{ $post->url }}" class="full-link"></a>
</div>
