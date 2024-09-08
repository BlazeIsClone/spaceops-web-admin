<?php

namespace App\RoutePaths\Admin\Inquiry;

use App\RoutePaths\Admin\AdminRoutePathInterface;
use App\Services\InquiryService;

class InquiryRoutePath implements AdminRoutePathInterface
{
	public function __construct(
		protected InquiryService $inquiryService,
	) {
	}

	public const INDEX = 'admin.inquiry.index';

	public const STORE = 'admin.inquiry.store';

	public const EDIT = 'admin.inquiry.edit';

	public const UPDATE = 'admin.inquiry.update';

	public const DESTROY = 'admin.inquiry.destroy';

	/**
	 * Name of the resource.
	 */
	public function resourceName(): string
	{
		return $this->inquiryService->modelName();
	}

	/**
	 * Associative mapping of actions to route names.
	 */
	public static function routeMappings(): array
	{
		return [
			'List' => [self::INDEX],
			'Edit' => [self::EDIT, self::UPDATE],
			'Delete' => [self::DESTROY],
		];
	}
}
