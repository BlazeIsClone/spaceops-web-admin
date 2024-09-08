<?php

namespace App\Http\Requests\Admin\Post;

use App\Enums\PostCategoryStatus;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Models\PostCategory;
use Illuminate\Support\Str;

class PostCategoryStoreRequest extends BaseRequest
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
				'required', 'string', 'min:3', 'max:255', Rule::unique(PostCategory::class, 'name'),
			],
			'status' => [
				'required', 'integer', new Enum(PostCategoryStatus::class),
			],
			'slug' => [
				'required', 'string', 'min:1', 'max:255', Rule::unique(PostCategory::class, 'slug'),
			],
			'title' => [
				'required', 'string', 'min:3', 'max:255',
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
