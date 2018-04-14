<?php
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$api = app(Dingo\Api\Routing\Router::class);

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\v1'
], function ($api) {
    $api->group([
        'as' => 'auth',
        'namespace' => 'Auth',
        'middleware' => 'api.throttle',
        'limit' => config('api.rateLimits.sign.limits'),
        'expires' => config('api.rateLimits.sign.expires'),
    ], function ($api) {
        $api->post('user', ['as' => 'register', 'uses' => 'AuthController@store']);
    });
});