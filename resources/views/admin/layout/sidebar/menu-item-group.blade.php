@props(['content', 'icon', 'lang'])

<span class="menu-link">
    <span class="menu-icon">{!! getIcon($icon, 'fs-2') !!}</span>
    <span class="menu-title">
        @if (!empty($lang))
            {{ __($lang . '.Plural') }}
        @else
            {{ $content }}
        @endif

        @if (isset($count) && $count > 0)
            <span class="badge badge-sm badge-circle badge-light-danger mx-2">
                {{ $count }}
            </span>
        @endif
    </span>
    <span class="menu-arrow"></span>
</span>
