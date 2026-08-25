<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Visa;
use App\Country;
use App\UsefullLinks;
use App\Packages;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
         Paginator::useBootstrap();
        Schema::defaultStringLength(191);

        \View::composer('*', function($view) {
           $request = app(\Illuminate\Http\Request::class);

            $data['app'] = $request->header('app');
            $data["detect"]         = new Agent();
            $expiresAt = Carbon::now()->endOfDay();
    
            $data['setting']        = getSettings();
             $data['useful_links'] = UsefullLinks::where('active',1)->where('show_in_sidebar',1)->get();
            $view->with($data);
        });
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
