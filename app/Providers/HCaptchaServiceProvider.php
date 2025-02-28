<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
    public function boot()
    {
        Validator::extend('hcaptcha', function ($attribute, $value, $parameters, $validator) {
            $client = new \GuzzleHttp\Client();

            $response = $client->post('https://hcaptcha.com/siteverify', [
                'form_params' => [
                    'secret' => config('services.hcaptcha.secret'),
                    'response' => $value,
                    'remoteip' => request()->ip()
                ]
            ]);

            $body = json_decode((string)$response->getBody());
            return $body->success;
        }, 'Пожалуйста, подтвердите, что вы не робот.');
    }
}
