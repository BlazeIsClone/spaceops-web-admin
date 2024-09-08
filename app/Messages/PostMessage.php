<?php

namespace App\Messages;

use App\Messages\BaseMessage;
use App\Services\PostService;

class PostMessage extends BaseMessage
{
	public function __construct(
		protected PostService $postService,
	) {
	}

	protected function modelName(): string
	{
		return $this->postService->modelName();
	}
}
