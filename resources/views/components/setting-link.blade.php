@props(['name', 'settings'])

<div class="mb-8">
    <x-input-label :value="__('Link')" />
    <div class="rounded border p-10">
        @php $link = $settings->get($name); @endphp

        <div class="row">
            <div class="col-lg-6">
                @php $field = $name . '[title]'; @endphp
                <x-input-label for="{{ $field }}" :value="__('Title')" />
                <x-input-text id="{{ $field }}" name="{{ $field }}" type="text" :value="old($field, !empty($link['title']) ? $link['title'] : '')" />
                <x-input-error :messages="$errors->get($field)" />
            </div>

            <div class="col-lg-6">
                @php $field = $name . '[url]'; @endphp
                <x-input-label for="{{ $field }}" :value="__('URL')" />
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="fa-solid fa-globe"></i>
                    </span>
                    <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                        :value="old($field, !empty($link['url']) ? $link['url'] : '')" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>
            </div>
        </div>
    </div>
</div>
