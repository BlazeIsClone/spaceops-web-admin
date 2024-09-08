<?php

namespace App\Models;

use App\Enums\PostCategoryStatus;
use App\Models\Interfaces\HasRelationsInterface;
use App\Models\Traits\HasCreatedBy;
use App\Models\Traits\HasUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class PostCategory extends Model implements HasMedia, HasRelationsInterface
{
	use HasFactory, InteractsWithMedia, HasCreatedBy, HasUpdatedBy;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'status',
		'name',
		'slug',
		'title',
		'description',
		'meta_title',
		'meta_description',
		'created_by',
		'updated_by',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'status' => PostCategoryStatus::class,
	];

	/**
	 * Model media collections.
	 */
	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('featured_image')
			->useDisk('media')
			->singleFile();

		$this->addMediaCollection('listing_image')
			->useDisk('media')
			->singleFile();
	}

	/**
	 * Interact with media.
	 */
	protected function featuredImage(): Attribute
	{
		return Attribute::make(
			get: fn () => $this->getMedia('featured_image'),
		);
	}

	/**
	 * Interact with media.
	 */
	protected function listingImage(): Attribute
	{
		return Attribute::make(
			get: fn () => $this->getMedia('listing_image'),
		);
	}

	/**
	 * Scope a query to only include active.
	 */
	public function scopeActive(Builder $query): void
	{
		$query->where('status', PostCategoryStatus::ACTIVE);
	}

	/**
	 * Define model methods with Has relations.
	 */
	public function defineHasRelationships(): array
	{
		return [];
	}

	/**
	 * Get the front page url.
	 */
	public function getUrlAttribute(): string
	{
		return url('post-categories/' . $this->slug);
	}

	/**
	 * Get posts associated with the post category.
	 */
	public function posts(): BelongsToMany
	{
		return $this->belongsToMany(Post::class, 'post_has_category');
	}
}
