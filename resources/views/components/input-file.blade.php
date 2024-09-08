<input type="file" id="{{ $id }}" name="{{ $name }}"
    {{ $attributes->merge(['class' => $attributes->get('multiple') ? 'pond-multiple' : 'pond-single'])->except(['value', 'temp']) }} />

@php
    $tempFileIds = old($id, []);
    $tempFileIds = array_filter(is_array($tempFileIds) ? $tempFileIds : [$tempFileIds]);
@endphp

@push('footer')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const id = '{{ $id }}';
            const fileMaxSize = {{ $fileMaxSize ?? 'undefined' }};
            const fileMaxCount = {{ $fileMaxCount ?? 'undefined' }};
            const mimeType = {{ $mimeType ?? 'undefined' }};

            const value = @json(is_array($value) ? $value : ($value ? $value->toArray() : null));
            const tempFileIds = @json(is_array($tempFileIds) ? $tempFileIds : [$tempFileIds]);

            const files = Array.isArray(value) ? value : undefined;

            window.AppFilePond.create(
                id,
                files,
                fileMaxSize,
                fileMaxCount,
                mimeType,
                tempFileIds,
                '{{ $attributes->get('multiple') ? 'multiple' : 'single' }}',
            );
        });
    </script>
@endpush
