<?php

namespace App\Services;

use App\Models\Post;
use App\Models\PostCategory;
use App\Repositories\PostRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostService extends BaseService
{
	public function __construct(
		private PostRepository $postRepository,
		private PostCategoryService $postCategoryService,
		private SettingService $settingService,
	) {
		parent::__construct($postRepository);
	}

	/**
	 * Get all resources.
	 */
	public function getAllPosts(): Collection
	{
		return $this->postRepository->getAll();
	}

	/**
	 * Get active resources.
	 */
	public function getActivePosts(array $postIds = null): Collection
	{
		return $this->postRepository->getActive($postIds);
	}

	/**
	 * Get paginated resources.
	 */
	public function getPaginatedPosts(PostCategory $postCategory = null): LengthAwarePaginator
	{
		return $this->postRepository->getPaginated($postCategory);
	}

	/**
	 * Create a new resource.
	 */
	public function createPost(array $attributes): Post
	{
		return $this->postRepository->create([
			...$attributes,
			'created_by' => $this->getAdminAuthUser()->id,
		]);
	}

	/**
	 * Get the specified resource.
	 */
	public function getPost(int $postId = null, string $slug = null): ?Post
	{
		if ($slug) {
			return $this->postRepository->getBySlug($slug);
		}

		return $this->postRepository->getById($postId);
	}

	/**
	 * Get the specified resource attribute.
	 */
	public function getPostWhere(string $columnName, mixed $value): ?Post
	{
		return $this->postRepository->getFirstWhere($columnName, $value);
	}

	/**
	 * Delete a specific resource.
	 */
	public function deletePost(int $postId): int
	{
		return $this->postRepository->delete($postId);
	}

	/**
	 * Update an existing resource.
	 */
	public function updatePost(int $postId, array $newAttributes): bool
	{
		return $this->postRepository->update($postId, [
			...$newAttributes,
			'updated_by' => $this->getAdminAuthUser()->id,
		]);
	}

	/**
	 * Get all post categories.
	 */
	public function getAllPostCategories(): Collection
	{
		return $this->postCategoryService->getAllPostCategories();
	}
}
