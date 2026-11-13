<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $globalRapidXSession;
        // if(isset($_SESSION)){
        //     session_start();
        //     $globalRapidXSession = $_SESSION['rapidx_user_id'];
        // }else{
            $globalRapidXSession = '';
        // }
        
        Schema::defaultStringLength(255);
        View::share('globalRapidXSession', $globalRapidXSession);
    }
}
