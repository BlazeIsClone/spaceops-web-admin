<?php

namespace App\Repositories;

use App\Exceptions\JsonResponseException;
use App\Models\PostCategory;
use App\Services\MediaService;
use App\Services\Traits\HandlesMedia;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PostCategoryRepository extends BaseRepository
{
	use HandlesMedia;

	public function __construct(
		private PostCategory $postCategory,
		private MediaService $mediaService,
	) {
		parent::__construct($postCategory);
	}

	/**
	 * Get all resources.
	 */
	public function getAll(): Collection
	{
		return $this->postCategory::all();
	}

	/**
	 * Get active resources.
	 */
	public function getActive(array $postCategoryIds = null): Collection
	{
		if ($postCategoryIds) {
			return $this->postCategory->active()
				->findMany($postCategoryIds);
		}

		return $this->postCategory->active()
			->get();
	}

	/**
	 * Get resources with pagination.
	 */
	public function getPaginated(): LengthAwarePaginator
	{
		$query = $this->postCategory->active()
			->orderBy('created_at', 'desc');

		return $query->paginate();
	}

	/**
	 * Get the specified resource.
	 */
	public function getById(int $postCategoryId): ?PostCategory
	{
		return $this->postCategory::find($postCategoryId);
	}

	/**
	 * Get the specified resource by slug.
	 */
	public function getBySlug(string $slug): ?PostCategory
	{
		return $this->postCategory
			->where('slug', $slug)
			->active()
			->first();
	}

	/**
	 * Get the resource by column name and value.
	 */
	public function getFirstWhere(string $columnName, mixed $value): ?PostCategory
	{
		return $this->postCategory::where($columnName, $value)->first();
	}

	/**
	 * Delete a specific resource.
	 */
	public function delete(int $postCategoryId): bool
	{
		$postCategory = $this->getById($postCategoryId);

		$this->checkModelHasParentRelations($postCategory);

		if ($postCategory && $postCategory->posts()->exists()) {
			throw new JsonResponseException("Cannot delete record because it is related to other resources.");
		}

		try {
			return $postCategory->delete($postCategoryId);
		} catch (QueryException $e) {
			throw new \Exception($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new resource.
	 */
	public function create(array $attributes): PostCategory
	{
		$featuredImage = Arr::pull($attributes, 'featured_image');
		$listingImage = Arr::pull($attributes, 'listing_image');

		$postCategory = $this->postCategory::create($attributes);

		$this->syncMedia($postCategory, 'featured_image', $featuredImage);
		$this->syncMedia($postCategory, 'listing_image', $listingImage);

		return $postCategory;
	}

	/**
	 * Update an existing resource.
	 */
	public function update(int $postCategoryId, array $newAttributes): bool
	{
		$featuredImage = Arr::pull($newAttributes, 'featured_image');
		$listingImage = Arr::pull($newAttributes, 'listing_image');

		$postCategory = $this->postCategory::findOrFail($postCategoryId)
			->fill($newAttributes);

		$this->syncMedia($postCategory, 'featured_image', $featuredImage);
		$this->syncMedia($postCategory, 'listing_image', $listingImage);

		return $postCategory->save();
	}
}
