<?php

namespace App\RoutePaths\Admin\Post;

use App\RoutePaths\Admin\AdminRoutePathInterface;
use App\Services\PostCategoryService;

class PostCategoryRoutePath implements AdminRoutePathInterface
{
	public function __construct(
		protected PostCategoryService $postCategoryService,
	) {
	}

	public const INDEX = 'admin.post.category.index';

	public const CREATE = 'admin.post.category.create';

	public const STORE = 'admin.post.category.store';

	public const EDIT = 'admin.post.category.edit';

	public const UPDATE = 'admin.post.category.update';

	public const DESTROY = 'admin.post.category.destroy';

	/**
	 * Name of the resource.
	 */
	public function resourceName(): string
	{
		return $this->postCategoryService->modelName();
	}

	/**
	 * Associative mapping of actions to route names.
	 */
	public static function routeMappings(): array
	{
		return [
			'List' => [self::INDEX],
			'Create' => [self::CREATE, self::STORE],
			'Edit' => [self::EDIT, self::UPDATE],
			'Delete' => [self::DESTROY],
		];
	}
}
