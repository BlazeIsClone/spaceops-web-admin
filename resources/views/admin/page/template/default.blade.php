@extends('admin.page.edit')

@section('template')
    <div class="card mt-8">
        <div class="card-header">
            <header>
                <h2 class="text-lg mt-8 font-medium text-gray-900">
                    {{ __('Banner Section') }}
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

            <div class="col-xl-6">
                <x-input-label for="banner_image" :value="__('Banner Image')" />
                <x-input-file id="banner_image" name="banner_image" :fileMaxSize="2" :value="$settings->getMedia('banner_image')" />
                <x-input-error class="mt-2" :messages="$errors->get('banner_image')" />
            </div>
        </div>
    </div>

    <div class="card mt-8">
        <div class="card-header">
            <header>
                <h2 class="text-lg mt-8 font-medium text-gray-900">
                    {{ __('Page Content') }}
                </h2>
            </header>
        </div>
        <div class="card-body">
            <div class="mb-8">
                <x-input-label for="page_content" :value="__('Page Content')" />
                <x-input-editor name="page_content" id="page_content">
                    {{ old('page_content', $settings->get('page_content')) }}
                </x-input-editor>
                <x-input-error :messages="$errors->get('page_content')" />
            </div>
        </div>
    </div>
@endsection
