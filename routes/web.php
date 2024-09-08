<?php

use App\Http\Controllers\Front\Home\HomeController;
use App\Http\Controllers\Front\RobotsController;
use App\RoutePaths\Front\FrontRoutePath;
use App\RoutePaths\Front\Page\PageRoutePath;
use Illuminate\Support\Env;
use Illuminate\Support\Facades\Route;
use Spatie\Sitemap\SitemapGenerator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'show'])
    ->name(PageRoutePath::HOME);

Route::get('/robots.txt', [RobotsController::class, 'show'])
    ->name(FrontRoutePath::ROBOTS);

if (Env::get('SITEMAP', false)) {
    SitemapGenerator::create(PageRoutePath::HOME)
        ->writeToFile('sitemap.xml');
}
