    <div class="card my-8">
        <div class="card-header">
            <header>
                <h3 class="text-lg mt-8 font-medium text-gray-900">
                    {{ __('Meta Content') }}
                </h3>
            </header>
        </div>
        <div class="card-body">
            <section>
                @if (!empty($module) && is_bool($module))
                    <div class="mb-8">
                        <x-input-label for="meta_title" :value="__('Meta Title')" />
                        <x-input-text name="meta_title" id="meta_title" :value="old('meta_title')" />
                        <x-input-error :messages="$errors->get('meta_title')" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="meta_description" :value="__('Meta Description')" />
                        <x-input-textarea name="meta_description" id="meta_description" :maxlength="255">
                            {{ old('meta_description') }}
                        </x-input-textarea>
                        <x-input-error :messages="$errors->get('meta_description')" />
                    </div>
                @elseif (!empty($module))
                    <div class="mb-8">
                        <x-input-label for="meta_title" :value="__('Meta Title')" />
                        <x-input-text name="meta_title" id="meta_title" :value="old('meta_title', $module?->meta_title)" />
                        <x-input-error :messages="$errors->get('meta_title')" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="meta_description" :value="__('Meta Description')" />
                        <x-input-textarea name="meta_description" id="meta_description" :maxlength="255">
                            {{ old('meta_description', $module?->meta_description) }}
                        </x-input-textarea>
                        <x-input-error :messages="$errors->get('meta_description')" />
                    </div>
                @else
                    <div class="mb-8">
                        <x-input-label for="meta_title" :value="__('Meta Title')" />
                        <x-input-text name="meta_title" id="meta_title" :value="old('meta_title', $settings->get('meta_title'))" />
                        <x-input-error :messages="$errors->get('meta_title')" />
                    </div>

                    <div class="mb-8">
                        <x-input-label for="meta_description" :value="__('Meta Description')" />
                        <x-input-textarea name="meta_description" id="meta_description" :maxlength="255">
                            {{ old('meta_description', $settings->get('meta_description')) }}
                        </x-input-textarea>
                        <x-input-error :messages="$errors->get('meta_description')" />
                    </div>
                @endif
            </section>
        </div>
    </div>
