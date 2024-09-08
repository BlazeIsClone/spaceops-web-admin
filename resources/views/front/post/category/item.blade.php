<div class="post-item">
    <div class="top">
        <div class="image">
            @if ($postCategory->getFirstMedia('listing_image') || $postCategory->getFirstMedia('featured_image'))
                <img src="{{ $postCategory->getFirstMedia('listing_image')?->getFullUrl() ?: $postCategory->getFirstMedia('featured_image')?->getFullUrl() }}"
                    alt="{{ $postCategory->name }}" class="full-image">
            @endif
        </div>
        <h4>{{ $postCategory->name }}</h4>
    </div>
    <a href="{{ $postCategory->url }}" class="theme-btn">View More</a>
    <a href="{{ $postCategory->url }}" class="full-link"></a>
</div>
