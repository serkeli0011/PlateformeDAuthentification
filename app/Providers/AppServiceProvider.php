<?php

namespace App\Providers;

use App\Models\Verification;
use App\Notifications\DocumentNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Verification::created(function(Verification $v){
            Notification::route('mail',$v->email_verif)->notify(new DocumentNotification($v));
        });
    }
}
