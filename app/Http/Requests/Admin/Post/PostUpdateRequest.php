<?php

namespace App\Http\Requests\Admin\Post;

use App\Enums\PostStatus;
use App\Http\Requests\BaseRequest;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostUpdateRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
	 */
	public function rules(): array
	{
		return [
			'name' => [
				'required', 'string', 'min:3', 'max:255', Rule::unique(Post::class, 'name')->ignore($this->post),
			],
			'status' => [
				'required', 'integer', new Enum(PostStatus::class),
			],
			'slug' => [
				'required', 'string', 'min:1', 'max:255', Rule::unique(Post::class, 'slug')->ignore($this->post),
			],
			'title' => [
				'required', 'string', 'min:3', 'max:255',
			],
			'post_categories' => [
				'nullable', 'array', Rule::exists(PostCategory::class, 'id'),
			],
			'short_description' => [
				'nullable', 'string', 'max:180',
			],
			'description' => [
				'nullable', 'string', 'max:5000',
			],
			'featured_image' =>	[
				'required', 'string',
			],
			'listing_image' =>	[
				'nullable', 'string',
			],
			'meta_title' =>	[
				'nullable', 'string', 'max:255',
			],
			'meta_description' =>	[
				'nullable', 'string', 'max:2048'
			],
		];
	}

	/**
	 * Prepare the data for validation.
	 */
	protected function prepareForValidation(): void
	{
		$this->merge([
			'slug' => Str::slug($this->slug),
		]);
	}
}
