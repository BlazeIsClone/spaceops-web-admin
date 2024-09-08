<?php

use Illuminate\Support\Facades\Route;
use App\RoutePaths\Admin\Post\PostCategoryRoutePath;
use App\Http\Controllers\Admin\Post\PostCategoryController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\App;

Route::middleware(['verified.admin'])->group(function () {

	Route::controller(PostCategoryController::class)
		->prefix(App::make(PostCategoryController::class)->getRoutePrefix())
		->group(function () {

			Route::get('/create', 'create')
				->middleware(Authorize::using(PostCategoryRoutePath::CREATE))
				->name(PostCategoryRoutePath::CREATE);

			Route::post('/', 'store')
				->middleware(Authorize::using(PostCategoryRoutePath::STORE))
				->name(PostCategoryRoutePath::STORE);

			Route::get('/{postCategory}/edit', 'edit')
				->middleware(Authorize::using(PostCategoryRoutePath::EDIT))
				->name(PostCategoryRoutePath::EDIT);

			Route::put('/{postCategory}',  'update')
				->middleware(Authorize::using(PostCategoryRoutePath::UPDATE))
				->name(PostCategoryRoutePath::UPDATE);

			Route::delete('/{postCategory}',  'destroy')
				->middleware(Authorize::using(PostCategoryRoutePath::DESTROY))
				->name(PostCategoryRoutePath::DESTROY);

			Route::middleware(Authorize::using(PostCategoryRoutePath::INDEX))
				->group(function () {
					Route::get('/', 'index')->name(PostCategoryRoutePath::INDEX);
					Route::post('/list', 'index');
				});
		});
});
