<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
    <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true"
        data-kt-scroll-activate="true" data-kt-scroll-height="auto"
        data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
        data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">

        <!--begin::Menu-->
        <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true"
            data-kt-menu-expand="false">

            @canany([AdminRoutePath::DASHBOARD])
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    @include('admin.layout.sidebar.menu-item-group', [
                        'content' => 'Dashboards',
                        'icon' => 'element-11',
                    ])

                    <div class="menu-sub menu-sub-accordion">
                        @can(AdminRoutePath::DASHBOARD)
                            @include('admin.layout.sidebar.menu-item', [
                                'content' => 'Home',
                                'route' => AdminRoutePath::DASHBOARD,
                            ])
                        @endcan
                    </div>
                </div>
            @endcan

            @canany([InquiryRoutePath::INDEX])
                @include('admin.layout.sidebar.menu-heading', ['content' => 'Inquiries'])
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    @php $lang = 'inquiries'; @endphp

                    @include('admin.layout.sidebar.menu-item-group', [
                        'icon' => 'directbox-default',
                    ])

                    <div class="menu-sub menu-sub-accordion">
                        @can(InquiryRoutePath::INDEX)
                            @include('admin.layout.sidebar.menu-item', [
                                'route' => InquiryRoutePath::INDEX,
                            ])
                        @endcan
                    </div>
                </div>
            @endcanany

            @if (Route::has(PostRoutePath::INDEX) || Route::has(PostRoutePath::CREATE))
                @canany([PostRoutePath::INDEX, PostRoutePath::CREATE])
                    @include('admin.layout.sidebar.menu-heading', ['content' => 'Blog'])

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        @php $lang = 'posts'; @endphp

                        @include('admin.layout.sidebar.menu-item-group', [
                            'icon' => 'document',
                        ])

                        <div class="menu-sub menu-sub-accordion">
                            @can(PostRoutePath::INDEX)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => PostRoutePath::INDEX,
                                ])
                            @endcan

                            @can(PostRoutePath::CREATE)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => PostRoutePath::CREATE,
                                ])
                            @endcan
                        </div>
                    </div>
                @endcanany
            @endif

            @if (Route::has(PostCategoryRoutePath::INDEX) || Route::has(PostCategoryRoutePath::CREATE))
                @canany([PostCategoryRoutePath::INDEX, PostCategoryRoutePath::CREATE])
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        @php $lang = 'post-categories'; @endphp

                        @include('admin.layout.sidebar.menu-item-group', [
                            'icon' => 'some-files',
                        ])

                        <div class="menu-sub menu-sub-accordion">
                            @can(PostCategoryRoutePath::INDEX)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => PostCategoryRoutePath::INDEX,
                                ])
                            @endcan

                            @can(PostCategoryRoutePath::CREATE)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => PostCategoryRoutePath::CREATE,
                                ])
                            @endcan
                        </div>
                    </div>
                @endcanany
            @endif

            @canany([PageSettingRoutePath::HOME, PageSettingRoutePath::CONTACT, PageSettingRoutePath::INQUIRY,
                PageSettingRoutePath::POST])
                @include('admin.layout.sidebar.menu-heading', ['content' => 'Pages'])

                <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                    @php $lang = null; @endphp

                    @include('admin.layout.sidebar.menu-item-group', [
                        'content' => 'Pages',
                        'icon' => 'some-files',
                    ])

                    <div class="menu-sub menu-sub-accordion">
                        @can(PageSettingRoutePath::HOME)
                            @include('admin.layout.sidebar.menu-item', [
                                'content' => 'Home',
                                'route' => PageSettingRoutePath::HOME,
                            ])
                        @endcan

                        @can(PageSettingRoutePath::CONTACT)
                            @include('admin.layout.sidebar.menu-item', [
                                'content' => 'Contact',
                                'route' => PageSettingRoutePath::CONTACT,
                            ])
                        @endcan

                        @can(PageSettingRoutePath::INQUIRY)
                            @include('admin.layout.sidebar.menu-item', [
                                'content' => 'Inquiry',
                                'route' => PageSettingRoutePath::INQUIRY,
                            ])
                        @endcan

                        @can(PageSettingRoutePath::POST)
                            @include('admin.layout.sidebar.menu-item', [
                                'content' => 'Post Listing',
                                'route' => PageSettingRoutePath::POST,
                            ])
                        @endcan
                    </div>
                </div>
            @endcanany

            @if (Route::has(PageRoutePath::INDEX) || Route::has(PageRoutePath::CREATE))
                @canany([PageRoutePath::INDEX, PageRoutePath::CREATE])
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        @php $lang = 'pages'; @endphp

                        @include('admin.layout.sidebar.menu-item-group', [
                            'icon' => 'some-files',
                        ])

                        <div class="menu-sub menu-sub-accordion">
                            @can(PageRoutePath::INDEX)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => PageRoutePath::INDEX,
                                ])
                            @endcan

                            @can(PageRoutePath::CREATE)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => PageRoutePath::CREATE,
                                ])
                            @endcan
                        </div>
                    </div>
                @endcanany
            @endif

            @if (Route::has(CustomerRoutePath::INDEX) || Route::has(CustomerRoutePath::CREATE))
                @canany([CustomerRoutePath::INDEX, CustomerRoutePath::CREATE])
                    @include('admin.layout.sidebar.menu-heading', ['content' => 'Customers'])

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        @php $lang = 'customer'; @endphp

                        @include('admin.layout.sidebar.menu-item-group', [
                            'icon' => 'people',
                        ])

                        <div class="menu-sub menu-sub-accordion">
                            @can(CustomerRoutePath::INDEX)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => CustomerRoutePath::INDEX,
                                ])
                            @endcan

                            @can(CustomerRoutePath::CREATE)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => CustomerRoutePath::CREATE,
                                ])
                            @endcan
                        </div>
                    </div>
                @endcanany
            @endif

            @if (Route::has(UserRoutePath::INDEX) || Route::has(UserRoutePath::CREATE))
                @canany([UserRoutePath::INDEX, UserRoutePath::CREATE])
                    @include('admin.layout.sidebar.menu-heading', ['content' => 'Admin Users'])

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        @php $lang = 'users'; @endphp

                        @include('admin.layout.sidebar.menu-item-group', [
                            'icon' => 'user-square',
                        ])

                        <div class="menu-sub menu-sub-accordion">
                            @can(UserRoutePath::INDEX)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => UserRoutePath::INDEX,
                                ])
                            @endcan

                            @can(UserRoutePath::CREATE)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => UserRoutePath::CREATE,
                                ])
                            @endcan
                        </div>
                    </div>
                @endcanany
            @endif

            @if (Route::has(UserRoleRoutePath::INDEX) || Route::has(UserRoleRoutePath::CREATE))
                @canany([UserRoleRoutePath::INDEX, UserRoleRoutePath::CREATE])
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                        @php $lang = 'user-roles'; @endphp

                        @include('admin.layout.sidebar.menu-item-group', [
                            'icon' => 'shield',
                        ])

                        <div class="menu-sub menu-sub-accordion">
                            @can(UserRoleRoutePath::INDEX)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => UserRoleRoutePath::INDEX,
                                ])
                            @endcan

                            @can(UserRoleRoutePath::CREATE)
                                @include('admin.layout.sidebar.menu-item', [
                                    'route' => UserRoleRoutePath::CREATE,
                                ])
                            @endcan
                        </div>
                    </div>
                @endcanany
            @endif

            @if (Route::has(SettingRoutePath::GENERAL) || Route::has(SettingRoutePath::MAIL))
                @canany([SettingRoutePath::GENERAL, SettingRoutePath::MAIL])
                    @include('admin.layout.sidebar.menu-heading', ['content' => 'Settings'])

                    @php $lang = null; @endphp

                    @can(SettingRoutePath::GENERAL)
                        @include('admin.layout.sidebar.menu-item', [
                            'content' => 'General Settings',
                            'route' => SettingRoutePath::GENERAL,
                            'icon' => 'color-swatch',
                        ])
                    @endcan

                    @can(SettingRoutePath::MAIL)
                        @include('admin.layout.sidebar.menu-item', [
                            'content' => 'Mail Settings',
                            'route' => SettingRoutePath::MAIL,
                            'icon' => 'sms',
                        ])
                    @endcan
                @endcanany
            @endif

        </div>
        <!--end::Menu-->
    </div>
</div>
