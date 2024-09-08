<x-default-layout>
    <form method="post" action="{{ $action }}" autocomplete="off">
        @method('post')
        @csrf

        <div class="d-flex flex-column mb-5">
            <div class="card">
                <div class="card-header">
                    <header>
                        <h2 class="text-lg mt-8 font-medium text-gray-900">
                            {{ __($pageData['title']) }}
                        </h2>
                    </header>
                </div>
                <div class="card-body">
                    <div class="mb-8">
                        <x-input-label for="banner_content" :value="__('Banner Content')" />
                        <x-input-editor name="banner_content" id="banner_content">
                            {{ old('banner_content', $settings->get('banner_content')) }}
                        </x-input-editor>
                        <x-input-error :messages="$errors->get('banner_content')" />
                    </div>

                    <div class="col-xl-4">
                        <x-input-label for="banner_logo" :value="__('Banner Logo')" />
                        <x-input-file id="banner_logo" name="banner_logo" :fileMaxSize="2" :value="$settings->getMedia('banner_logo')" />
                        <x-input-error class="mt-2" :messages="$errors->get('banner_logo')" />
                    </div>

                    <div class="col-xl-4">
                        <x-input-label for="banner_image" :value="__('Banner Image')" />
                        <x-input-file id="banner_image" name="banner_image" :fileMaxSize="2" :value="$settings->getMedia('banner_image')" />
                        <x-input-error class="mt-2" :messages="$errors->get('banner_image')" />
                    </div>
                </div>
            </div>

            <div class="accordion accordion-icon-toggle mt-8" id="kt_accordion_setting">
                <x-setting-accordion :name="__('blog_section')" :title="__('Blog Section')" :$settings>
                    <div class="mb-8">
                        @php $field = 'post_content'; @endphp
                        <x-input-label for="{{ $field }}" :value="__('Content')" />
                        <x-input-editor id="{{ $field }}" name="{{ $field }}">
                            {{ old($field, $settings->get($field)) }}
                        </x-input-editor>
                        <x-input-error :messages="$errors->get($field)" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="post_items" :value="__('Posts')" />
                        <x-input-select name="post_items[]" data-placeholder="Select Posts" data-hide-search="false"
                            multiple>
                            @if ($posts->isNotEmpty())
                                @foreach ($posts as $post)
                                    <option value="{{ $post->id }}" @selected(\in_array($post->id, old('post_items', $settings->get('post_items') ?? [])))>
                                        {{ $post->name }}
                                    </option>
                                @endforeach
                            @endif
                        </x-input-select>
                        <x-input-error :messages="$errors->get('post_items')" />
                    </div>
                </x-setting-accordion>
            </div>

            @include('admin.partials.section-meta')
        </div>

        <div class="col-lg-12">
            <div class="card mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-end gap-4">
                        <x-button-primary>{{ __('Update') }}</x-button-primary>
                    </div>
                </div>
            </div>
        </div>

    </form>
</x-default-layout>
