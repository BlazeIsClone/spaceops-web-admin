<div class="post-aside">
    <div class="content-wrapper">
        <h3>{{ __('Categories') }}</h3>
    </div>

    @if ($allPostCategories->isNotEmpty())
        <ul>
            @foreach ($allPostCategories as $postCategory)
                <li>
                    <a href="{{ $postCategory->url }}"
                        class="{{ request('post_category') == $postCategory->name ? 'active' : '' }}">
                        {{ $postCategory->name }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
