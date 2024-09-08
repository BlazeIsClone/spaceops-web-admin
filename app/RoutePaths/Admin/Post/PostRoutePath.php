<?php

namespace App\RoutePaths\Admin\Post;

use App\RoutePaths\Admin\AdminRoutePathInterface;
use App\Services\PostService;

class PostRoutePath implements AdminRoutePathInterface
{
	public function __construct(
		protected PostService $postService,
	) {
	}

	public const INDEX = 'admin.post.index';

	public const CREATE = 'admin.post.create';

	public const STORE = 'admin.post.store';

	public const EDIT = 'admin.post.edit';

	public const UPDATE = 'admin.post.update';

	public const DESTROY = 'admin.post.destroy';

	/**
	 * Name of the resource.
	 */
	public function resourceName(): string
	{
		return $this->postService->modelName();
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
