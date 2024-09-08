<x-auth-layout>

    <!--begin::Form-->
    <form action="{{ route(AdminAuthRoutePath::LOGIN) }}" method="POST">
        @csrf
        <!--begin::Heading-->
        <div class="text-center mb-11">
            <!--begin::Title-->
            <h1 class="text-dark fw-bolder mb-3">
                {{ __('Confirm Password') }}
            </h1>
            <!--end::Title-->

            <!--begin::Subtitle-->
            <div class="text-gray-500 fw-semibold fs-6">
                {{ __('Admin User Authentication') }}
            </div>
            <!--end::Subtitle--->
        </div>
        <!--begin::Heading-->

        <!--begin::Separator-->
        <div class="separator my-14"></div>
        <!--end::Separator-->

        <!--begin::Input group--->
        <div class="fv-row mb-8">
            <!--begin::Email-->
            <x-input-label for="email" :value="__('Email')" />
            <x-input-text id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')"
                placeholder="sam@company.com" required autofocus autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
            <!--end::Email-->
        </div>
        <!--end::Input group--->

        <!--end::Input group--->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!--begin::Input wrapper-->
            <div>
                <x-input-label for="email" :value="__('Password')" />
                <!--begin::Password-->
                <div class="position-relative mb-3">
                    <x-input-text id="password" name="password" type="password" class="mt-1 block w-full"
                        :value="old('password')" placeholder="Your password" required autocomplete="current-password" />
                    <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                        data-kt-password-meter-control="visibility">
                        <i class="bi bi-eye-slash fs-2"></i>
                        <i class="bi bi-eye fs-2 d-none"></i>
                    </span>
                </div>
                <!--end::Password-->
            </div>
            <!--end::Input wrapper-->
        </div>
        <!--end::Input group--->

        <!--begin::Submit button-->
        <div class="d-grid mb-10">
            <x-button-primary>{{ __('Confirm') }}</x-button-primary>
        </div>
        <!--end::Submit button-->

    </form>
    <!--end::Form-->

</x-auth-layout>
