<?php

namespace App\Http\Controllers\Front\Post;

use App\Enums\SettingModule;
use App\Http\Controllers\Front\FrontBaseController;
use App\Http\Requests\Front\Post\PostIndexRequest;
use App\Messages\PostMessage;
use App\RoutePaths\Front\Post\PostRoutePath;
use App\Services\PostCategoryService;
use App\Services\PostService;
use App\Services\SettingService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class PostController extends FrontBaseController
{
    public function __construct(
        private SettingService $settingService,
        private PostRoutePath $postRoutePath,
        private PostMessage $postMessage,
        private PostService $postService,
        private PostCategoryService $postCategoryService,
    ) {
        parent::__construct(settingService: $settingService);
    }

    /**
     * Show the resource.
     */
    public function index(PostIndexRequest $request): View|RedirectResponse
    {
        $this->sharePageData(SettingModule::POST);

        $attributes = $request->getAttributes();

        $selectedPostCategory = $this->postCategoryService
            ->getPostCategoryWhere('name', $attributes['post_category'] ?? null);

        return view($this->postRoutePath::INDEX, [
            'allPostCategories' => $this->postCategoryService->getActivePostCategories(),
            'allPosts' => $this->postService->getActivePosts(),
            'posts' => $this->postService->getPaginatedPosts($selectedPostCategory),
        ]);
    }

    /**
     * Show the resource.
     */
    public function show(string $slug): View|RedirectResponse
    {
        $this->sharePageData(SettingModule::POST);

        $post = $this->postService->getPost(slug: $slug);

        if (!$post) {
            return redirect()->route($this->postRoutePath::INDEX)
                ->withErrors($this->postMessage->notFound());
        }

        return view($this->postRoutePath::SHOW, [
            'allPostCategories' => $this->postCategoryService->getActivePostCategories(),
            'allPosts' => $this->postService->getActivePosts(),
            'post' => $post,
        ]);
    }
}
