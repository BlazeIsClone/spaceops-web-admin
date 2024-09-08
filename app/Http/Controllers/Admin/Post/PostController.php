<?php

namespace App\Http\Controllers\Admin\Post;

use App\Exceptions\RedirectResponseException;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Http\Requests\Admin\Post\PostStoreRequest;
use App\Http\Requests\Admin\Post\PostUpdateRequest;
use App\Http\Resources\Admin\Post\PostIndexResource;
use App\Messages\PostMessage;
use App\RoutePaths\Admin\Post\PostRoutePath;
use App\RoutePaths\Front\Post\PostRoutePath as FrontPostRoutePath;
use App\Services\PostService;
use App\Models\Post;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends AdminBaseController
{
    public function __construct(
        private PostRoutePath $postRoutePath,
        private PostService $postService,
        private PostMessage $postMessage,
    ) {
        parent::__construct(service: $postService);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Renderable|PostIndexResource
    {
        if ($request->ajax()) {
            $attributes = (object) $request->only(
                ['draw', 'columns', 'order', 'start', 'length', 'search']
            );

            $request->merge([
                'recordsAll' => $this->postService->getAllPosts(),
                'recordsFiltered' => $this->postService->getAllWithFilter(
                    filterColumns: ['id', 'name', 'status'],
                    filterQuery: $attributes,
                ),
            ]);

            return PostIndexResource::make($attributes);
        }

        $columns = $this->tableColumns(
            ['name', 'slug', 'categories', 'image']
        );

        $this->registerBreadcrumb();

        $this->sharePageData([
            'title' => $this->getActionTitle(),
            'createTitle' => $this->getActionTitle('create'),
        ]);

        return view($this->postRoutePath::INDEX, [
            'create' => route($this->postRoutePath::CREATE),
            'columnNames' => $columns,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Renderable
    {
        $this->registerBreadcrumb(
            parentRouteName: $this->postRoutePath::INDEX,
        );

        $this->sharePageData([
            'title' => $this->getActionTitle(),
        ]);

        return view($this->postRoutePath::CREATE, [
            'postCategories' => $this->postService->getAllPostCategories()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request): RedirectResponse|RedirectResponseException
    {
        $created = $this->postService->createPost($request->getAttributes());

        throw_if(!$created, RedirectResponseException::class, $this->postMessage->createFailed());

        return redirect()->route($this->postRoutePath::EDIT, $created)->with([
            'message' => $this->postMessage->createSuccess(),
            'status' => true,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): Renderable
    {

        $this->registerBreadcrumb(
            parentRouteName: $this->postRoutePath::INDEX,
            routeParameter: $post->id,
        );

        $this->sharePageData([
            'title' => $this->getActionTitle(),
            'frontUrl' => route(FrontPostRoutePath::SHOW, $post->slug),
        ]);

        return view($this->postRoutePath::EDIT, [
            'postCategories' => $this->postService->getAllPostCategories(),
            'post' => $post,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Post $post, PostUpdateRequest $request): RedirectResponse|RedirectResponseException
    {
        $updated = $this->postService->updatePost($post->id, $request->getAttributes());

        throw_if(!$updated, RedirectResponseException::class, $this->postMessage->updateFailed());

        return redirect()->route($this->postRoutePath::EDIT, $post)->with([
            'message' => $this->postMessage->updateSuccess(),
            'status' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): JsonResponse|RedirectResponseException
    {
        $deleted = $this->postService->deletePost($post->id);

        throw_if(!$deleted, RedirectResponseException::class, $this->postMessage->deleteFailed());

        return $this->jsonResponse()->message($this->postMessage->deleteSuccess())
            ->success();
    }
}
