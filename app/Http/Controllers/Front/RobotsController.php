<?php

namespace App\Http\Controllers\Front;

use App\Enums\SettingModule;
use App\Http\Controllers\Front\FrontBaseController;
use App\RoutePaths\Front\FrontRoutePath;
use App\Services\SettingService;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;

class RobotsController extends FrontBaseController
{
	public function __construct(
		private SettingService $settingService,
	) {
		parent::__construct(settingService: $settingService);
	}
	/**
	 * Show the resource.
	 */
	public function show(): HttpResponse
	{
		$pageData = $this->settingService->module(SettingModule::GENERAL);

		return Response::view(FrontRoutePath::ROBOTS, [
			'allow' => $pageData->get('robots'),
		])->header('Content-Type', 'text/plain');
	}
}
