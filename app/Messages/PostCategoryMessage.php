<?php

namespace App\Messages;

use App\Messages\BaseMessage;
use App\Services\PostCategoryService;

class PostCategoryMessage extends BaseMessage
{
	public function __construct(
		protected PostCategoryService $postCategoryService,
	) {
	}

	protected function modelName(): string
	{
		return $this->postCategoryService->modelName();
	}
}
