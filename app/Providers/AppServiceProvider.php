<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(8);              // طول 8 على الأقل
                // ->mixedCase()            // حرف كبير + صغير
                // ->numbers()              // رقم
                // ->symbols()              // رمز خاص (@#$%^&*)
                // ->uncompromised();       // مش مسربة في هجمات سابقة
        });
    }

}
