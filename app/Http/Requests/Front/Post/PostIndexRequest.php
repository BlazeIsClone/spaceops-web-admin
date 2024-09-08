<?php

namespace App\Http\Requests\Front\Post;

use App\Http\Requests\BaseRequest;
use App\Models\PostCategory;
use Illuminate\Validation\Rule;

class PostIndexRequest extends BaseRequest
{
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
	 */
	public function rules(): array
	{
		return [
			'post_category' => [
				'nullable', 'string', Rule::exists(PostCategory::class, 'name'),
			],
		];
	}
}
