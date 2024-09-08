<?php

use Illuminate\Support\Facades\Route;
use App\RoutePaths\Admin\Post\PostRoutePath;
use App\Http\Controllers\Admin\Post\PostController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\App;

Route::middleware(['verified.admin'])->group(function () {

	Route::controller(PostController::class)
		->prefix(App::make(PostController::class)->getRoutePrefix())
		->group(function () {

			Route::get('/create', 'create')
				->middleware(Authorize::using(PostRoutePath::CREATE))
				->name(PostRoutePath::CREATE);

			Route::post('/', 'store')
				->middleware(Authorize::using(PostRoutePath::STORE))
				->name(PostRoutePath::STORE);

			Route::get('/{post}/edit', 'edit')
				->middleware(Authorize::using(PostRoutePath::EDIT))
				->name(PostRoutePath::EDIT);

			Route::put('/{post}',  'update')
				->middleware(Authorize::using(PostRoutePath::UPDATE))
				->name(PostRoutePath::UPDATE);

			Route::delete('/{post}',  'destroy')
				->middleware(Authorize::using(PostRoutePath::DESTROY))
				->name(PostRoutePath::DESTROY);

			Route::middleware(Authorize::using(PostRoutePath::INDEX))
				->group(function () {
					Route::get('/', 'index')->name(PostRoutePath::INDEX);
					Route::post('/list', 'index');
				});
		});
});
