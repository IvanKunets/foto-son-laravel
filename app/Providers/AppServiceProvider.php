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
        // Единые требования к паролю для Hash и валидации (min + классы символов): усложняет подбор учётной записи администратора
        Password::defaults(function () {
            return Password::min(10)
                ->mixedCase()
                ->numbers();
        });
    }
}
