<?php

use App\Http\Controllers\Common\Media\MediaController;
use App\RoutePaths\Common\Media\MediaRoutePath;
use Illuminate\Support\Facades\Route;

Route::post('/common/media', [MediaController::class, 'store'])
	->name(MediaRoutePath::STORE);

Route::delete('/common/media/revert', [MediaController::class, 'revert'])
	->name(MediaRoutePath::REVERT);

Route::get('/common/media/restore/{id?}', [MediaController::class, 'restore'])
	->name(MediaRoutePath::RESTORE);
