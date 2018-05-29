<?php

namespace App\Providers;

use Dingo\Api\Facade\API;
use Dingo\Api\Transformer\Factory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app(Factory::class)->disableEagerLoading();

        API::error(function (ModelNotFoundException $e) {
            throw new NotFoundHttpException($e->getMessage());
        });

        API::error(function (AuthorizationException $e) {
            throw new AccessDeniedHttpException($e->getMessage());
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
