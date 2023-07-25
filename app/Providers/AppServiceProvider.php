<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\WebCrawlerService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(WebCrawlerService::class, function () {
            return new WebCrawlerService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
