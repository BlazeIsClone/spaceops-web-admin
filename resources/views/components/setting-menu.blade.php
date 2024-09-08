@props(['name', 'settings'])

<div class="form-repeater rounded border p-10" data-repeater-max-items="24">
    <div class="form-group">
        <div data-repeater-list="{{ $name }}">
            @php $menu = old($name, $settings->get($name)) ?? ['']; @endphp
            @foreach ($menu as $item)
                <div data-repeater-item class="mt-3">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <x-input-label :value="__('Title')" />
                            <x-input-text class="mb-2" name="title" value="{{ $item['title'] ?? '' }}" />
                        </div>
                        <div class="col-lg-4">
                            <x-input-label :value="__('Url')" />
                            <x-input-text class="mb-2" name="url" value="{{ $item['url'] ?? '' }}" />
                        </div>
                        <div class="col-lg-1">
                            <button type="button" data-repeater-delete
                                class="btn btn-icon btn-light-danger mt-3 mt-md-8">
                                <i class="fa fa-trash fs-9"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="form-group mt-5">
        <button type="button" data-repeater-create class="btn btn-sm btn-light-primary">
            <i class="fa fa-plus fs-6"></i> {{ __('Add') }}
        </button>
    </div>
</div>
