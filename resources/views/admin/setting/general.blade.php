<x-default-layout>
    <form method="post" action="{{ $action }}" autocomplete="off">
        @method('post')
        @csrf

        <div class="d-flex flex-column mb-5">
            <div class="card mb-5">
                <div class="card-header">
                    <header>
                        <h2 class="text-lg mt-8 font-medium text-gray-900">
                            {{ __($pageData['title']) }}
                        </h2>
                    </header>
                </div>
                <div class="card-body">
                    <div class="mb-8">
                        <x-input-label for="site_name" :value="__('Site Name')" />
                        <x-input-text id="site_name" name="site_name" type="text" :value="old('site_name', $settings->get('site_name'))" />
                        <x-input-error :messages="$errors->get('site_name')" />
                    </div>

                    <div class="mb-8 col-xl-4">
                        <x-input-label for="site_logo" :value="__('Site Logo')" />
                        <x-input-file id="site_logo" name="site_logo" :fileMaxSize="2" :value="$settings->getMedia('site_logo')" />
                        <x-input-error :messages="$errors->get('site_logo')" />
                    </div>

                    <div class="mb-8 col-xl-4">
                        <x-input-label for="site_favicon" :value="__('Site Favicon')" />
                        <x-input-file id="site_favicon" name="site_favicon" :fileMaxSize="1" :value="$settings->getMedia('site_favicon')" />
                        <x-input-error :messages="$errors->get('site_favicon')" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="compile_front_assets" :value="__('Compile Frontend Assets')" />
                        <x-input-switch id="compile_front_assets" name="compile_front_assets" :value="$settings->get('compile_front_assets')" />
                        <x-input-error :messages="$errors->get('compile_front_assets')" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="robots" :value="__('Search Engine Visibility')" />
                        <x-input-switch id="robots" name="robots" :value="$settings->get('robots')" />
                        <x-input-error :messages="$errors->get('robots')" />
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion accordion-icon-toggle mb-5" id="kt_accordion_setting">
            <x-setting-accordion :name="__('seo_options')" :title="__('SEO Options')" :$settings>
                <div class="mb-8">
                    @php $field = 'analytics_header_script'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Analytics Header Script')" />
                    <x-input-textarea id="{{ $field }}"
                        name="{{ $field }}">{{ old($field, $settings->get($field)) }}
                    </x-input-textarea>
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'analytics_body_script'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Analytics Body Script')" />
                    <x-input-textarea id="{{ $field }}"
                        name="{{ $field }}">{{ old($field, $settings->get($field)) }}
                    </x-input-textarea>
                    <x-input-error :messages="$errors->get($field)" />
                </div>
            </x-setting-accordion>

            <x-setting-accordion :name="__('social_media')" :title="__('Social Media')" :$settings>
                <div class="mb-8">
                    @php $field = 'social_media_facebook_link'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Facebook Link')" />
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fab fa-facebook"></i>
                        </span>
                        <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                            :value="old($field, $settings->get($field))" />
                        <x-input-error :messages="$errors->get($field)" />
                    </div>
                </div>

                <div class="mb-8">
                    @php $field = 'social_media_instagram_link'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Instagram Link')" />
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fab fa-instagram"></i>
                        </span>
                        <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                            :value="old($field, $settings->get($field))" />
                        <x-input-error :messages="$errors->get($field)" />
                    </div>
                </div>

                <div class="mb-8">
                    @php $field = 'social_media_twitter_link'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Twitter Link')" />
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fab fa-x-twitter"></i>
                        </span>
                        <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                            :value="old($field, $settings->get($field))" />
                        <x-input-error :messages="$errors->get($field)" />
                    </div>
                </div>

                <div class="mb-8">
                    @php $field = 'social_media_linkedin_link'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('LinkedIn Link')" />
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fab fa-linkedin"></i>
                        </span>
                        <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                            :value="old($field, $settings->get($field))" />
                        <x-input-error :messages="$errors->get($field)" />
                    </div>
                </div>

                <div class="mb-8">
                    @php $field = 'social_media_youtube_link'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('YouTube Link')" />
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fab fa-youtube"></i>
                        </span>
                        <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                            :value="old($field, $settings->get($field))" />
                        <x-input-error :messages="$errors->get($field)" />
                    </div>
                </div>
            </x-setting-accordion>

            <x-setting-accordion :name="__('contacts')" :title="__('Contacts')" :$settings>
                <div class="mb-8">
                    @php $field = 'contact_phone'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Phone')" />
                    <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                        :value="old($field, $settings->get($field))" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'contact_email'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Email')" />
                    <x-input-text id="{{ $field }}" name="{{ $field }}" type="email"
                        :value="old($field, $settings->get($field))" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'contact_address'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Address')" />
                    <x-input-textarea id="{{ $field }}"
                        name="{{ $field }}">{{ old($field, $settings->get($field)) }}
                    </x-input-textarea>
                    <x-input-error :messages="$errors->get($field)" />
                </div>
            </x-setting-accordion>

            <x-setting-accordion :name="__('footer_options')" :title="__('Footer')" :$settings>
                <div class="mb-8 col-xl-4">
                    @php $field = 'footer_logo'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Logo')" />
                    <x-input-file id="{{ $field }}" name="{{ $field }}" :fileMaxSize="2"
                        :value="$settings->getMedia($field)" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8 col-xl-4">
                    @php $field = 'footer_background'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Background')" />
                    <x-input-file id="{{ $field }}" name="{{ $field }}" :fileMaxSize="2"
                        :value="$settings->getMedia($field)" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_content'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Content')" />
                    <x-input-editor id="{{ $field }}" name="{{ $field }}">
                        {{ old($field, $settings->get($field)) }}
                    </x-input-editor>
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_contact'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Contacts Title')" />
                    <x-input-textarea id="{{ $field }}"
                        name="{{ $field }}">{{ old($field, $settings->get($field)) }}
                    </x-input-textarea>
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_one_title'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu One Title')" />
                    <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                        :value="old($field, $settings->get($field))" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_one'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu One')" />
                    <x-setting-menu :name="$field" :$settings />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_two_title'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu Two Title')" />
                    <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                        :value="old($field, $settings->get($field))" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_two'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu Two')" />
                    <x-setting-menu :name="$field" :$settings />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_three_title'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu Three Title')" />
                    <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                        :value="old($field, $settings->get($field))" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_three'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu Three')" />
                    <x-setting-menu :name="$field" :$settings />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_four_title'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu Four Title')" />
                    <x-input-text id="{{ $field }}" name="{{ $field }}" type="text"
                        :value="old($field, $settings->get($field))" />
                    <x-input-error :messages="$errors->get($field)" />
                </div>

                <div class="mb-8">
                    @php $field = 'footer_menu_four'; @endphp
                    <x-input-label for="{{ $field }}" :value="__('Menu Four')" />
                    <x-setting-menu :name="$field" :$settings />
                    <x-input-error :messages="$errors->get($field)" />
                </div>
            </x-setting-accordion>
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
