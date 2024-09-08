<?php

namespace App\Services;

use App\Models\PostCategory;
use App\Repositories\PostCategoryRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PostCategoryService extends BaseService
{
	public function __construct(
		private PostCategoryRepository $postCategoryRepository,
		private SettingService $settingService,
	) {
		parent::__construct($postCategoryRepository);
	}

	/**
	 * Get the model human readable name.
	 */
	public function modelName(): string
	{
		return 'log category';
	}

	/**
	 * Get all resources.
	 */
	public function getAllPostCategories(): Collection
	{
		return $this->postCategoryRepository->getAll();
	}

	/**
	 * Get active resources.
	 */
	public function getActivePostCategories(array $postCategoryIds = null): Collection
	{
		return $this->postCategoryRepository->getActive($postCategoryIds);
	}

	/**
	 * Get paginated resources.
	 */
	public function getPaginatedPostCategories(): LengthAwarePaginator
	{
		return $this->postCategoryRepository->getPaginated();
	}

	/**
	 * Create a new resource.
	 */
	public function createPostCategory(array $attributes): PostCategory
	{
		return $this->postCategoryRepository->create([
			...$attributes,
			'created_by' => $this->getAdminAuthUser()->id,
		]);
	}

	/**
	 * Get the specified resource.
	 */
	public function getPostCategory(int $postCategoryId = null, string $slug = null): ?PostCategory
	{
		if ($slug) {
			return $this->postCategoryRepository->getBySlug($slug);
		}

		return $this->postCategoryRepository->getById($postCategoryId);
	}

	/**
	 * Get the specified resource attribute.
	 */
	public function getPostCategoryWhere(string $columnName, mixed $value): ?PostCategory
	{
		return $this->postCategoryRepository->getFirstWhere($columnName, $value);
	}

	/**
	 * Delete a specific resource.
	 */
	public function deletePostCategory(int $postCategoryId): int
	{
		return $this->postCategoryRepository->delete($postCategoryId);
	}

	/**
	 * Update an existing resource.
	 */
	public function updatePostCategory(int $postCategoryId, array $newAttributes): bool
	{
		return $this->postCategoryRepository->update($postCategoryId, [
			...$newAttributes,
			'updated_by' => $this->getAdminAuthUser()->id,
		]);
	}
}
