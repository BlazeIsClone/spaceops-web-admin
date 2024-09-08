<?php

use App\Http\Controllers\Front\Post\PostCategoryController;
use App\Http\Controllers\Front\Post\PostController;
use App\RoutePaths\Front\Post\PostCategoryRoutePath;
use App\RoutePaths\Front\Post\PostRoutePath;
use Illuminate\Support\Facades\Route;

Route::get('/posts', [PostController::class, 'index'])
	->name(PostRoutePath::INDEX);

Route::get('/posts/{slug}', [PostController::class, 'show'])
	->name(PostRoutePath::SHOW);

Route::get('/post-categories', [PostCategoryController::class, 'index'])
	->name(PostCategoryRoutePath::INDEX);

Route::get('/post-categories/{slug}', [PostCategoryController::class, 'show'])
	->name(PostCategoryRoutePath::SHOW);
