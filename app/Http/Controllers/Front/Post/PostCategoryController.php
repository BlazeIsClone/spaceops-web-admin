<?php

namespace App\Http\Controllers\Front\Post;

use App\Enums\SettingModule;
use App\Http\Controllers\Front\FrontBaseController;
use App\Messages\PostCategoryMessage;
use App\RoutePaths\Front\Post\PostCategoryRoutePath;
use App\Services\PostCategoryService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostCategoryController extends FrontBaseController
{
    public function __construct(
        private SettingService $settingService,
        private PostCategoryRoutePath $postRoutePath,
        private PostCategoryMessage $postMessage,
        private PostCategoryService $postCategoryService,
    ) {
        parent::__construct(settingService: $settingService);
    }

    /**
     * Show the resource.
     */
    public function index(): View|RedirectResponse
    {
        $this->sharePageData(SettingModule::POST);

        return view($this->postRoutePath::INDEX, [
            'allPostCategories' => $this->postCategoryService->getActivePostCategories(),
            'postCategories' => $this->postCategoryService->getPaginatedPostCategories(),
        ]);
    }

    /**
     * Show the resource.
     */
    public function show(string $slug): View|RedirectResponse
    {
        $this->sharePageData(SettingModule::POST);

        $post = $this->postCategoryService->getPostCategory(slug: $slug);

        if (!$post) {
            return redirect()->route($this->postRoutePath::INDEX)
                ->withErrors($this->postMessage->notFound());
        }

        return view($this->postRoutePath::SHOW, [
            'allPostCategories' => $this->postCategoryService->getActivePostCategories(),
            'postCategory' => $post,
        ]);
    }
}
