<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Traits\JsonResponseTrait;
use App\Services\BaseService;

class CommonBaseController extends Controller
{
	use JsonResponseTrait;

	public function __construct(
		protected BaseService $service,
	) {
		//
	}
}
