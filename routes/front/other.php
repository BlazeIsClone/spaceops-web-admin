<?php

use App\Http\Controllers\Front\Contact\ContactController;
use App\Http\Controllers\Front\Inquiry\InquiryController;
use App\RoutePaths\Front\Page\PageRoutePath;
use Illuminate\Support\Facades\Route;

Route::get('/contact', [ContactController::class, 'show'])
    ->name(PageRoutePath::CONTACT);

Route::post('/contact', [ContactController::class, 'store'])
    ->name(PageRoutePath::CONTACT);

Route::get('/inquiry', [InquiryController::class, 'show'])
    ->name(PageRoutePath::INQUIRY);

Route::post('/inquiry', [InquiryController::class, 'store'])
    ->name(PageRoutePath::INQUIRY);
