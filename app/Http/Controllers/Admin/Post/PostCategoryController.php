<?php

namespace App\Http\Controllers\Admin\Post;

use App\Exceptions\RedirectResponseException;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Post\PostCategoryStoreRequest;
use App\Http\Requests\Admin\Post\PostCategoryUpdateRequest;
use App\Http\Resources\Admin\Post\PostCategoryIndexResource;
use App\Messages\PostCategoryMessage;
use App\RoutePaths\Admin\Post\PostCategoryRoutePath;
use App\RoutePaths\Front\Post\PostCategoryRoutePath as FrontPostCategoryRoutePath;
use App\Services\PostCategoryService;
use App\Models\PostCategory;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostCategoryController extends AdminBaseController
{
    public function __construct(
        private PostCategoryRoutePath $postCategoryRoutePath,
        private PostCategoryService $postCategoriesService,
        private PostCategoryMessage $postCategoriesMessage,
    ) {
        parent::__construct(service: $postCategoriesService);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Renderable|PostCategoryIndexResource
    {
        if ($request->ajax()) {
            $attributes = (object) $request->only(
                ['draw', 'columns', 'order', 'start', 'length', 'search']
            );

            $request->merge([
                'recordsAll' => $this->postCategoriesService->getAllPostCategories(),
                'recordsFiltered' => $this->postCategoriesService->getAllWithFilter(
                    filterColumns: ['id', 'name', 'status'],
                    filterQuery: $attributes,
                ),
            ]);

            return PostCategoryIndexResource::make($attributes);
        }

        $columns = $this->tableColumns(
            ['name', 'slug', 'image']
        );

        $this->registerBreadcrumb();

        $this->sharePageData([
            'title' => $this->getActionTitle(),
            'createTitle' => $this->getActionTitle('create'),
        ]);

        return view($this->postCategoryRoutePath::INDEX, [
            'create' => route($this->postCategoryRoutePath::CREATE),
            'columnNames' => $columns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Renderable
    {
        $this->registerBreadcrumb(
            parentRouteName: $this->postCategoryRoutePath::INDEX,
        );

        $this->sharePageData([
            'title' => $this->getActionTitle(),
        ]);

        return view($this->postCategoryRoutePath::CREATE, []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCategoryStoreRequest $request): RedirectResponse|RedirectResponseException
    {
        $created = $this->postCategoriesService->createPostCategory($request->getAttributes());

        throw_if(!$created, RedirectResponseException::class, $this->postCategoriesMessage->createFailed());

        return redirect()->route($this->postCategoryRoutePath::EDIT, $created)->with([
            'message' => $this->postCategoriesMessage->createSuccess(),
            'status' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategory $postCategory): Renderable
    {

        $this->registerBreadcrumb(
            parentRouteName: $this->postCategoryRoutePath::INDEX,
            routeParameter: $postCategory->id,
        );

        $this->sharePageData([
            'title' => $this->getActionTitle(),
            'frontUrl' => route(FrontPostCategoryRoutePath::SHOW, $postCategory->slug),
        ]);

        return view($this->postCategoryRoutePath::EDIT, [
            'postCategory' => $postCategory,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCategory $postCategory, PostCategoryUpdateRequest $request): RedirectResponse|RedirectResponseException
    {
        $updated = $this->postCategoriesService->updatePostCategory($postCategory->id, $request->getAttributes());

        throw_if(!$updated, RedirectResponseException::class, $this->postCategoriesMessage->updateFailed());

        return redirect()->route($this->postCategoryRoutePath::EDIT, $postCategory)->with([
            'message' => $this->postCategoriesMessage->updateSuccess(),
            'status' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategory $postCategory): JsonResponse|RedirectResponseException
    {
        $deleted = $this->postCategoriesService->deletePostCategory($postCategory->id);

        throw_if(!$deleted, RedirectResponseException::class, $this->postCategoriesMessage->deleteFailed());

        return $this->jsonResponse()->message($this->postCategoriesMessage->deleteSuccess())
            ->success();
    }
}
