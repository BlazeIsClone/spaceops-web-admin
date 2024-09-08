@props(['lang', 'content', 'route'])

<div class="menu-item">
    <a class="menu-link" href="{{ route($route) }}">
        @isset($icon)
            <span class="menu-icon">{!! getIcon($icon, 'fs-2') !!}</span>
        @else
            <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
            </span>
        @endisset

        <span class="menu-title">
            @if (!empty($lang))
                @if (getRouteAction($route) === 'create')
                    {{ __('Create New') }} {{ __($lang . '.Singular') }}
                @else
                    {{ __('View All') }} {{ __($lang . '.Plural') }}
                @endif
            @else
                {{ $content }}
            @endif
        </span>
    </a>
</div>
