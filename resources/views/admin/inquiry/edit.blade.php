<x-default-layout :model="$inquiry">

    <form method="POST" action="{{ route(InquiryRoutePath::UPDATE, $inquiry) }}" autocomplete="off" id="resource_form">
        @method('put')
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
                        <div class="mb-8">
                            <x-input-label for="name" :value="__('Name')" required />
                            <x-input-text id="name" name="name" type="text" :value="old('name', $inquiry->name)" required />
                            <x-input-error :messages="$errors->get('name')" />
                        </div>
                    </div>
                </div>

                @if ($inquiry->customer)
                    <div class="card mt-8">
                        <div class="card-header">
                            <header>
                                <h2 class="text-lg mt-8 font-medium text-gray-800">
                                    {{ __('Customer Information') }}
                                </h2>
                            </header>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach ($inquiry->customer as $key => $value)
                                    <div class="mb-4 col-lg-4">
                                        <x-input-label :value="__(str()->title(str()->replace('_', ' ', $key)))" />
                                        <p class="font-medium">{{ $value ?: __('-') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <x-form-metadata :model="$inquiry" type="Update">
                <div class="mb-10">
                    <x-input-label for="status" required>Status</x-input-label>
                    <x-input-select name="status" data-placeholder="Select Status" data-hide-search="true" required>
                        @foreach (InquiryStatus::toSelectOptions() as $option)
                            <option value="{{ $option->value }}" @selected($option->value == old('status', $inquiry->status->value))>
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
            {!! file_get_contents(resource_path('js/admin/inquiry.js')) !!}
        </script>
        @endenv

        @env('production')
        <script src="{{ asset('assets/js/admin/inquiry.js') }}"></script>
        @endenv
    @endpush
</x-default-layout>
