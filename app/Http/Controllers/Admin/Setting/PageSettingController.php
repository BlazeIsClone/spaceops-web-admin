<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Enums\SettingModule;
use App\Http\Controllers\Admin\Setting\BaseSettingController;
use App\Messages\SettingMessage;
use App\RoutePaths\Admin\Setting\PageSettingRoutePath;
use App\RoutePaths\Front\Page\PageRoutePath;
use App\RoutePaths\Front\Post\PostRoutePath;
use App\Services\PostService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Session;

class PageSettingController extends BaseSettingController
{
    public function __construct(
        private SettingService $settingService,
        private PageSettingRoutePath $pageSettingRoutePath,
        private SettingMessage $settingMessage,
        private PostService $postService,
    ) {
        parent::__construct(service: $settingService);
    }

    /**
     * Show the form for updating the resource.
     */
    public function home(): View
    {
        $module = SettingModule::HOME;
        $resourceTitle = $this->getActionTitle();

        $this->registerBreadcrumb(routeTitle: $resourceTitle);

        Session::put($this->sessionKey, $module);

        $this->sharePageData([
            'title' => $resourceTitle,
            'frontUrl' => route(PageRoutePath::HOME),
        ]);

        return view($this->pageSettingRoutePath::HOME, [
            'posts' => $this->postService->getActivePosts(),
            'settings' => $this->settingService->module($module),
            'action' => $this->settingStoreRoute(),
        ]);
    }

    /**
     * Show the form for updating the resource.
     */
    public function post(): View
    {
        $module = SettingModule::POST;
        $resourceTitle = $this->getActionTitle();

        $this->registerBreadcrumb(routeTitle: $resourceTitle);

        Session::put($this->sessionKey, $module);

        $this->sharePageData([
            'title' => $resourceTitle,
            'frontUrl' => route(PostRoutePath::INDEX),
        ]);

        return view($this->pageSettingRoutePath::POST, [
            'settings' => $this->settingService->module($module),
            'action' => $this->settingStoreRoute(),
        ]);
    }

    /**
     * Show the form for updating the resource.
     */
    public function contact(): View
    {
        $module = SettingModule::CONTACT;
        $resourceTitle = $this->getActionTitle();

        $this->registerBreadcrumb(routeTitle: $resourceTitle);

        Session::put($this->sessionKey, $module);

        $this->sharePageData([
            'title' => $resourceTitle,
            'frontUrl' => route(PageRoutePath::CONTACT),
        ]);

        return view($this->pageSettingRoutePath::CONTACT, [
            'settings' => $this->settingService->module($module),
            'action' => $this->settingStoreRoute(),
        ]);
    }

    /**
     * Show the form for updating the resource.
     */
    public function inquiry(): View
    {
        $module = SettingModule::INQUIRY;
        $resourceTitle = $this->getActionTitle();

        $this->registerBreadcrumb(routeTitle: $resourceTitle);

        Session::put($this->sessionKey, $module);

        $this->sharePageData([
            'title' => $resourceTitle,
            'frontUrl' => route(PageRoutePath::INQUIRY),
        ]);

        return view($this->pageSettingRoutePath::INQUIRY, [
            'settings' => $this->settingService->module($module),
            'action' => $this->settingStoreRoute(),
        ]);
    }
}
