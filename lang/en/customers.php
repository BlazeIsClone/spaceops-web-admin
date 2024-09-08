<?php

use App\Services\CustomerService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

/** @var CustomerService $service  */
$service = App::make(CustomerService::class);

return [
	'singular' => Str::of($service->modelName())->singular()->lower()->toString(),
	'plural' => Str::of($service->modelName())->plural()->lower()->toString(),
	'Singular' => Str::of($service->modelName())->singular()->title()->toString(),
	'Plural' => Str::of($service->modelName())->plural()->title()->toString(),
];
