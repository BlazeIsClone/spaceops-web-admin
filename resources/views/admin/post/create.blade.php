<x-default-layout>

    <form method="post" action="{{ route(PostRoutePath::STORE) }}" autocomplete="off" id="resource_form">
        @method('post')
        @csrf

        <div class="d-flex flex-column flex-lg-row">
            <div class="flex-lg-row-fluid mb-10 mb-lg-0 me-lg-7 me-xl-10" id="resource_form_fieldset">
                <div class="card">
                    <div class="card-header">
                        <header>
                            <h2 class="text-lg mt-8 font-medium text-gray-900">
                                {{ __($pageData['title']) }}
                            </h2>
                        </header>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-8">
                                    <x-input-label for="name" :value="__('Name')" required />
                                    <x-input-text id="name" name="name" type="text" :value="old('name')"
                                        required />
                                    <x-input-error :messages="$errors->get('name')" />
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="mb-8">
                                    <x-input-label for="slug" :value="__('Slug')" required />
                                    <x-input-text id="slug" name="slug" type="text" :value="old('slug')"
                                        required />
                                    <x-input-error :messages="$errors->get('slug')" />
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <x-input-label for="title" :value="__('Title')" required />
                            <x-input-text id="title" name="title" type="text" :value="old('title')" required />
                            <x-input-error :messages="$errors->get('title')" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="short_description" :value="__('Short Description')" required />
                            <x-input-textarea id="short_description" name="short_description" :maxlength="180"
                                required>{{ old('short_description') }}</x-input-textarea>
                            <x-input-error :messages="$errors->get('short_description')" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="post_categories" :value="__('Categories')" />
                            <div class="rounded border p-5">
                                <div class="row">
                                    @if ($postCategories->isNotEmpty())
                                        @foreach ($postCategories as $postCategory)
                                            <div class="col-lg-3 py-3 d-flex gap-4 align-items-center">
                                                <x-input-checkbox id="post_categories_{{ $postCategory->id }}"
                                                    name="post_categories[]" class="text-end" :value="$postCategory->id"
                                                    :checked="\in_array($postCategory->id, old('post_categories', []))" multiple />
                                                <x-input-label for="post_categories_{{ $postCategory->id }}"
                                                    :value="$postCategory->name" class="mb-0" />
                                            </div>
                                        @endforeach
                                    @else
                                        <span class="text-muted">{{ __('No Resources Found') }}</span>
                                    @endif
                                </div>
                            </div>
                            <x-input-error :messages="$errors->get('post_categories')" />
                        </div>

                        <div class="mb-8">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-input-editor name="description" id="description">
                                {{ old('description') }}
                            </x-input-editor>
                            <x-input-error :messages="$errors->get('description')" />
                        </div>

                        <div class="row">
                            <div class="col-xl-6">
                                <x-input-label for="featured_image" :value="__('Featured Image')" required />
                                <x-input-file id="featured_image" name="featured_image" :value="null"
                                    :fileMaxSize="2" required />
                                <x-input-error :messages="$errors->get('featured_image')" />
                            </div>

                            <div class="col-xl-6">
                                <x-input-label for="listing_image" :value="__('Listing Image')" />
                                <x-input-file id="listing_image" name="listing_image" :value="null"
                                    :fileMaxSize="2" />
                                <x-input-error :messages="$errors->get('listing_image')" />
                            </div>
                        </div>
                    </div>
                </div>

                @include('admin.partials.section-meta', ['module' => true])
            </div>

            <x-form-metadata type="Create">
                <div class="mb-10">
                    <x-input-label for="status" required>Status</x-input-label>
                    <x-input-select name="status" data-placeholder="Select Status" data-hide-search="true" required>
                        @foreach (PostStatus::toSelectOptions() as $option)
                            <option value="{{ $option->value }}" @selected($option->value == old('status', PostStatus::ACTIVE->value))>
                                {{ $option->name }}
                            </option>
                        @endforeach
                    </x-input-select>
                    <x-input-error :messages="$errors->get('status')" />
                </div>
            </x-form-metadata>

        </div>
    </form>

    @push('footer')
        @env('local')
        <script>
            {!! file_get_contents(resource_path('js/admin/post.js')) !!}
        </script>
        @endenv

        @env('production')
        <script src="{{ asset('assets/js/admin/post.js') }}"></script>
        @endenv
    @endpush
</x-default-layout>
