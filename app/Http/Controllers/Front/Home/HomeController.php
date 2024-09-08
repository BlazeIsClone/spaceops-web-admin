<?php

namespace App\Http\Controllers\Front\Home;

use App\Enums\SettingModule;
use App\Http\Controllers\Front\FrontBaseController;
use App\RoutePaths\Front\Page\PageRoutePath;
use App\Services\PostService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HomeController extends FrontBaseController
{
    public function __construct(
        private SettingService $settingService,
        private PostService $postService,
    ) {
        parent::__construct(settingService: $settingService);
    }

    /**
     * Show the resource.
     */
    public function show(): View|RedirectResponse
    {
        addHtmlClass('body', 'home');

        $this->sharePageData(SettingModule::HOME);

        $pageData = $this->settingService->module(SettingModule::HOME);

        return view(PageRoutePath::HOME, [
            'posts' => $this->postService->getActivePosts($pageData->get('post_items')),
        ]);
    }
}
