<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Models\Interfaces\HasRelationsInterface;
use App\Models\Traits\HasCreatedBy;
use App\Models\Traits\HasUpdatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia, HasRelationsInterface
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
		'short_description',
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
		'status' => PostStatus::class,
	];

	/**
	 * Get the formatted date attribute.
	 */
	public function getReadableDateAttribute(): string
	{
		return Carbon::parse($this->created_at)->format('d M Y');
	}

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
		$query->where('status', PostStatus::ACTIVE);
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
		return url('posts/' . $this->slug);
	}

	/**
	 * Get post categories associated with the post.
	 */
	public function categories(): BelongsToMany
	{
		return $this->belongsToMany(PostCategory::class, 'post_has_category');
	}
}
