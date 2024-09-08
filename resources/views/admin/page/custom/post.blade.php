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
                </div>
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
