<?php

namespace App\Messages;

use App\Services\InquiryService;

class InquiryMessage extends BaseMessage
{
	public function __construct(
		protected InquiryService $inquiryService,
	) {}

	protected function modelName(): string
	{
		return $this->inquiryService->modelName();
	}

	/**
	 * Get success message.
	 */
	public function formSuccess(): string
	{
		return __('Your inquiry has been successfully submitted.');
	}

	/**
	 * Get failure message.
	 */
	public function formFailure(): string
	{
		return __('There was an error processing your request.');
	}
}
