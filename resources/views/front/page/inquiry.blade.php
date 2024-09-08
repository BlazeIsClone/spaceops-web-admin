<x-front-layout>
    <section class="sub-page-banner">
        @if ($image = $pageData->getFirstMedia('banner_image'))
            <img src="{{ $image?->getFullUrl() }}" alt="{{ settings(SettingModule::GENERAL)->get('site_name') }}"
                class="full-image" />
        @endif
        <div class="container">
            @if ($content = $pageData->get('banner_content'))
                <div class="content-wrapper">{!! $content !!}</div>
            @endif
        </div>
    </section>

    <section class="inquiry-section">
        <div class="container">
            @include('front.common.alert-error')

            <form action="{{ route(FrontPageRoutePath::INQUIRY) }}" method="POST" id="inquiry_form"
                class="needs-validation" novalidate>
                @csrf

                <div class="inquiry-card">
                    <div class="form-group">
                        <label class="form-label required" for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        <span class="invalid-feedback">Name is required.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                        <span class="invalid-feedback">Phone is required.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" required>
                        <span class="invalid-feedback">Email is required.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label required" for="trip_start_date">Trip Start Date</label>
                        <input type="date" name="trip_start_date" id="trip_start_date" class="form-control" required>
                        <span class="invalid-feedback">Arrival is required.</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="message">Message</label>
                        <textarea name="message" id="message" rows="3" class="form-control"></textarea>
                        <span class="invalid-feedback">Message is required.</span>
                    </div>

                    <div class="form-group">
                        <button class="theme-btn">
                            <span id="children">Send Inquiry</span>
                            <span id="loading" style="display: none;">
                                Processing <span class="spinner-border spinner-border-sm ms-2"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    @push('footer')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush
</x-front-layout>
