<?php

use App\Services\PostService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/** @var PostService $service  */
$service = App::make(PostService::class);

return [
	'singular' => Str::of($service->modelName())->singular()->lower()->toString(),
	'plural' => Str::of($service->modelName())->plural()->lower()->toString(),
	'Singular' => Str::of($service->modelName())->singular()->title()->toString(),
	'Plural' => Str::of($service->modelName())->plural()->title()->toString(),
];
