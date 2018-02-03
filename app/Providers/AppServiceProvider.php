<?php

namespace Ojlinks\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       view()->composer(['field','subject'], \Ojlinks\Http\ViewComposers\BookViewComposer::class);
        
        view()->share('currency', 'R');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
