<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;

class HCaptchaServiceProvider extends ServiceProvider
{
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
        Validator::extend('hcaptcha', function ($attribute, $value, $parameters, $validator) {
            $response = Http::asForm()->post('https://hcaptcha.com/siteverify', [
                'secret' => config('services.hcaptcha.secret'),
                'response' => $value,
                'remoteip' => request()->ip(),
            ]);

            return $response->json()['success'] ?? false;
        }, 'The hCaptcha verification failed.');
    }
}
