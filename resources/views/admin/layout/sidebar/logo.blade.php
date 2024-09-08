<!--begin::Logo-->
<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
    <!--begin::Logo image-->
    <a href="{{ route(AdminRoutePath::DASHBOARD) }}">
        <h1 class="text-dark fw-medium fs-3 app-sidebar-logo-default">
            {{ settings(SettingModule::GENERAL)->get('site_name') ?? env('APP_NAME') }}
        </h1>
    </a>
    <!--end::Logo image-->
    <!--begin::Sidebar toggle-->
    <!--begin::Minimized sidebar setup: -->
    @if (isset($_COOKIE['sidebar_minimize_state']) && $_COOKIE['sidebar_minimize_state'] === 'on')
        {{-- 1. "src/js/layout/sidebar.js" adds "sidebar_minimize_state" cookie value to save the sidebar minimize state. --}}
        {{-- 2. Set data-kt-app-sidebar-minimize="on" attribute for body tag. --}}
        {{-- 3. Set data-kt-toggle-state="active" attribute to the toggle element with "kt_app_sidebar_toggle" id. --}}
        {{-- 4. Add "active" class to to sidebar toggle element with "kt_app_sidebar_toggle" id. --}}
    @endif
    <!--end::Minimized sidebar setup: -->
    <div id="kt_app_sidebar_toggle"
        class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate"
        data-kt-toggle="true" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize"
        data-kt-toggle-state="active">
        {!! getIcon('black-left-line', 'fs-2 rotate-180') !!}
    </div>
    <script type="text/javascript">
        var sidebar_toggle = document.getElementById("kt_app_sidebar_toggle"); // Get the sidebar toggle button element
        if ("{{ Cookie::get('sidebar_minimize_state') }}" === "on") {
            document.body.setAttribute("data-kt-app-sidebar-minimize",
                "on"); // Set the 'data-kt-app-sidebar-minimize' attribute for the body tag
            sidebar_toggle.setAttribute("data-kt-toggle-state",
                "active"); // Set the 'data-kt-toggle-state' attribute for the sidebar toggle button
            sidebar_toggle.classList.add("active"); // Add the 'active' class to the sidebar toggle button
        }
    </script>
    <!--end::Sidebar toggle-->
</div>
<!--end::Logo-->
