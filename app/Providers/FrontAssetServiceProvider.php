<?php

namespace App\Providers;

use App\Enums\SettingModule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use MatthiasMullie\Minify;
use lessc;

class FrontAssetServiceProvider extends ServiceProvider
{
    private int $directoryMode = 0775;

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings') && settings(SettingModule::GENERAL)->get('compile_front_assets')) {

            $this->minifyCSS();

            $this->minifyJS();

            (new lessc())->compileFile(
                resource_path("css/front/less/master.less"),
                public_path("assets/css/front/master.css")
            );
        }
    }

    private function minifyCSS(): void
    {
        $minifier = new Minify\CSS();

        $minifier->add(public_path('bootstrap/bootstrap.min.css'));

        $minifier->add(public_path('fontawesome/fontawesome.all.min.css'));

        $minifier->add(public_path('mmenu/mmenu.css'));

        $minifier->add(public_path('assets/css/front/master.css'));

        $masterFilePath = public_path('assets/css/front/master.min.css');

        if (!File::exists($masterFilePath)) {
            File::makeDirectory(public_path('assets/css/front'), $this->directoryMode, true);
            File::put($masterFilePath, '');
        }

        $minifier->minify($masterFilePath);
    }

    private function minifyJS(): void
    {
        $minifier = new Minify\JS();

        $minifier->add(public_path('bootstrap/bootstrap.bundle.min.js'));

        $minifier->add(public_path('mmenu/mmenu.js'));

        $minifier->add(public_path('swiper/swiper-bundle.min.js'));

        $minifier->add(resource_path('js/front/custom.js'));

        $masterFilePath = public_path('assets/js/front/custom-combined.min.js');

        if (!File::exists($masterFilePath)) {
            File::makeDirectory(public_path('assets/js/front'), $this->directoryMode, true);
            File::put($masterFilePath, '');
        }

        $minifier->minify($masterFilePath);
    }
}
