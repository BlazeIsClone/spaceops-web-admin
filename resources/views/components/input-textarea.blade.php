@props(['disabled' => false, 'maxlength' => false])

<textarea {{ $disabled ? 'disabled' : '' }} @if (!$attributes->get('rows')) style="height: 100px;" @endif
    {!! $attributes->merge(['class' => 'form-control bg-transparent show-maxlength']) !!} @if ($maxlength) maxlength="{{ $maxlength }}" @endif>{{ $slot }}</textarea>
