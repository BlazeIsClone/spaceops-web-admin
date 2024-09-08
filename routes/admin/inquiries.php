<?php

use Illuminate\Support\Facades\Route;
use App\RoutePaths\Admin\Inquiry\InquiryRoutePath;
use App\Http\Controllers\Admin\Inquiry\InquiryController;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Support\Facades\App;

Route::middleware(['verified.admin'])->group(function () {

	Route::controller(InquiryController::class)
		->prefix(App::make(InquiryController::class)->getRoutePrefix())
		->group(function () {

			Route::post('/', 'store')
				->middleware(Authorize::using(InquiryRoutePath::STORE))
				->name(InquiryRoutePath::STORE);

			Route::get('/{inquiry}/edit', 'edit')
				->middleware(Authorize::using(InquiryRoutePath::EDIT))
				->name(InquiryRoutePath::EDIT);

			Route::put('/{inquiry}',  'update')
				->middleware(Authorize::using(InquiryRoutePath::UPDATE))
				->name(InquiryRoutePath::UPDATE);

			Route::delete('/{inquiry}',  'destroy')
				->middleware(Authorize::using(InquiryRoutePath::DESTROY))
				->name(InquiryRoutePath::DESTROY);

			Route::middleware(Authorize::using(InquiryRoutePath::INDEX))
				->group(function () {
					Route::get('/', 'index')->name(InquiryRoutePath::INDEX);
					Route::post('/list', 'index');
				});
		});
});
