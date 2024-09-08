@props(['name', 'id', 'value', 'checked' => false, 'required' => false, 'multiple' => false, 'attributes' => []])

<div {{ $attributes->merge(['class' => 'form-check form-check-custom ', 'required' => $required]) }}>
    @if ($multiple)
        <input class="form-check-input" type="checkbox" value="{{ $value }}" id="{{ $id }}"
            name="{{ $name }}" @isset($value) @checked($checked) @endisset />
    @else
        <input type='hidden' value="0" name="{{ $name }}">
        <input class="form-check-input @if ($attributes->get('visualElement')) checkbox-visual-toggle @endif" type="checkbox"
            value="1" id="{{ $id }}" name="{{ $name }}"
            data-visual-element="{{ $attributes->get('visualElement') }}"
            @isset($value) @checked($value) @endisset />
    @endif
</div>
