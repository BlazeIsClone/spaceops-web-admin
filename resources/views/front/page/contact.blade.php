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

    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-6">
                    <div class="contact-left-wrapper">
                        <div class="contact-details">
                            @if ($phone = settings(SettingModule::GENERAL)?->get('contact_phone'))
                                <div class="contact-row">
                                    <i class="fas fa-phone-alt"></i>
                                    <div>
                                        <h3>Phone</h3>
                                        <p>
                                            <a href="tel:{{ $phone }}">{{ $phone }}</a>
                                        </p>
                                    </div>
                                </div>
                            @endif

                            @if ($email = settings(SettingModule::GENERAL)?->get('contact_email'))
                                <div class="contact-row">
                                    <i class="fas fa-at"></i>
                                    <div>
                                        <h3>Email</h3>
                                        <a href="mailto:{{ $email }}">{{ $email }}</a>
                                    </div>
                                </div>
                            @endif

                            @if ($address = settings(SettingModule::GENERAL)?->get('contact_address'))
                                <div class="contact-row">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <div>
                                        <h3>Address</h3>
                                        <p>{!! nl2br($address) !!}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="contact-row social-media">
                                <h3>Social Media</h3>
                                @include('front.partials.social-media')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="contact-form content-wrapper">
                        <h2>Send us a message</h2>
                        <form action="{{ route(FrontPageRoutePath::CONTACT) }}" method="POST" id="contact_form"
                            class="needs-validation" novalidate>
                            @csrf

                            <div class="form-group">
                                <label class="form-label required" for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                                <span class="invalid-feedback">Name is required.</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label required" for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control" required>
                                <span class="invalid-feedback">Email is required.</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label required" for="phone">Phone</label>
                                <input type="text" name="phone" id="phone" class="form-control" required>
                                <span class="invalid-feedback">Phone is required.</span>
                            </div>

                            <div class="form-group">
                                <label class="form-label required" for="message">Message</label>
                                <textarea name="message" id="message" rows="3" class="form-control" required></textarea>
                                <span class="invalid-feedback">Message is required.</span>
                            </div>

                            <div class="form-group">
                                <button class="theme-btn">
                                    <span id="children">Send Message</span>
                                    <span id="loading" style="display: none;">
                                        Processing <span class="spinner-border spinner-border-sm ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if ($map = $pageData->get('location_map'))
        <section class="contact-map">
            <div class="container">
                <div class="location-map">{!! $map !!}</div>
            </div>
        </section>
    @endif

</x-front-layout>
