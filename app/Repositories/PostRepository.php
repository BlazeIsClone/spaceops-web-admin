<?php

namespace App\Repositories;

use App\Enums\PostCategoryStatus;
use App\Models\Post;
use App\Models\PostCategory;
use App\Services\MediaService;
use App\Services\Traits\HandlesMedia;
use Illuminate\Database\QueryException;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class PostRepository extends BaseRepository
{
	use HandlesMedia;

	public function __construct(
		private Post $post,
		private MediaService $mediaService,
	) {
		parent::__construct($post);
	}

	/**
	 * Get all resources.
	 */
	public function getAll(): Collection
	{
		return $this->post::all();
	}

	/**
	 * Get active resources.
	 */
	public function getActive(array $postIds = null): Collection
	{
		if ($postIds) {
			return $this->post->active()
				->findMany($postIds);
		}

		return $this->post->active()
			->get();
	}

	/**
	 * Get resources with pagination.
	 */
	public function getPaginated(PostCategory $postCategory = null): LengthAwarePaginator
	{
		$query = $this->post->active()
			->orderBy('created_at', 'desc');

		if ($postCategory) {
			$query->whereHas('categories', function ($query) use ($postCategory) {
				$query->where(function ($q) use ($postCategory) {
					$q->where('post_categories.id', $postCategory->id)
						->where('post_categories.status', PostCategoryStatus::ACTIVE);
				});
			});
		}

		return $query->paginate();
	}

	/**
	 * Get the specified resource.
	 */
	public function getById(int $postId): ?Post
	{
		return $this->post::find($postId);
	}

	/**
	 * Get the specified resource by slug.
	 */
	public function getBySlug(string $slug): ?Post
	{
		return $this->post
			->where('slug', $slug)
			->active()
			->first();
	}

	/**
	 * Get the resource by column name and value.
	 */
	public function getFirstWhere(string $columnName, mixed $value): ?Post
	{
		return $this->post::where($columnName, $value)->first();
	}

	/**
	 * Delete a specific resource.
	 */
	public function delete(int $postId): bool
	{
		$post = $this->getById($postId);

		$this->checkModelHasParentRelations($post);

		$post->categories()->detach();

		try {
			return $post->delete($postId);
		} catch (QueryException $e) {
			throw new \Exception($e->getMessage());

			return false;
		}
	}

	/**
	 * Create a new resource.
	 */
	public function create(array $attributes): Post
	{
		$categories = Arr::pull($attributes, 'post_categories', []);
		$featuredImage = Arr::pull($attributes, 'featured_image');
		$listingImage = Arr::pull($attributes, 'listing_image');

		$post = $this->post::create($attributes);

		$this->syncMedia($post, 'featured_image', $featuredImage);
		$this->syncMedia($post, 'listing_image', $listingImage);

		if ($post) {
			$post->categories()->sync($categories);
		}

		return $post;
	}

	/**
	 * Update an existing resource.
	 */
	public function update(int $postId, array $newAttributes): bool
	{
		$categories = Arr::pull($newAttributes, 'post_categories', []);
		$featuredImage = Arr::pull($newAttributes, 'featured_image');
		$listingImage = Arr::pull($newAttributes, 'listing_image');

		$post = $this->post::findOrFail($postId)
			->fill($newAttributes);

		$this->syncMedia($post, 'featured_image', $featuredImage);
		$this->syncMedia($post, 'listing_image', $listingImage);

		$saved = $post->save();

		if ($saved) {
			$post->categories()->sync($categories);
		}

		return $saved;
	}
}
