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
    'namespace' => 'App\Http\Controllers\Api\v1',
    'middleware' => 'serializer:array'
], function ($api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rateLimits.sign.limits'),
        'expires' => config('api.rateLimits.sign.expires'),
    ], function ($api) {
        $api->group([
            'namespace' => 'Auth',
        ], function ($api) {
            $api->post('user', 'UserController@store')->name('user.store');
            $api->post('captchas', 'CaptchasController@store')->name('captchas.store');
            $api->post('authorization', 'AuthorizationController@store')->name('authorization.store');
            $api->put('authorization', 'AuthorizationController@update')->name('authorization.update');
            $api->delete('authorization', 'AuthorizationController@delete')->name('authorization.delete');
            $api->get('user', ['middleware' => 'api.auth', 'uses' => 'UserController@show'])->name('user.show');
            $api->patch('user', ['middleware' => 'api.auth', 'uses' => 'UserController@upate'])->name('user.update');
        });
        $api->group(['middleware' => 'api.auth'], function ($api){
            $api->post('image', 'ImageController@store')->name('image.store');
        });

    });
});