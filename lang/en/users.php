<?php

use App\Services\UserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/** @var UserService $service  */
$service = App::make(UserService::class);

return [
	'singular' => Str::of($service->modelName())->singular()->lower()->toString(),
	'plural' => Str::of($service->modelName())->plural()->lower()->toString(),
	'Singular' => Str::of($service->modelName())->singular()->title()->toString(),
	'Plural' => Str::of($service->modelName())->plural()->title()->toString(),
];
