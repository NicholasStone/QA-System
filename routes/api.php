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
use Dingo\Api\Routing\Router;

$api = app(Router::class);

$api->version('v1', [
    'namespace' => 'App\Http\Controllers\Api\v1',
    'middleware' => 'serializer:array'
], function (Router $api) {
    $api->group([
        'middleware' => 'api.throttle',
        'limit' => config('api.rateLimits.sign.limits'),
        'expires' => config('api.rateLimits.sign.expires'),
    ], function (Router $api) {
        $api->group([
            'namespace' => 'Auth',
        ], function (Router $api) {
            $api->post('user', 'UserController@store')->name('user.store');
            $api->post('captchas', 'CaptchasController@store')->name('captchas.store');
            $api->post('authorization', 'AuthorizationController@store')->name('authorization.store');
            $api->put('authorization', 'AuthorizationController@update')->name('authorization.update');
            $api->delete('authorization', 'AuthorizationController@delete')->name('authorization.delete');
            $api->get('user', ['middleware' => 'api.auth', 'uses' => 'UserController@show'])->name('user.show');
            $api->patch('user', ['middleware' => 'api.auth', 'uses' => 'UserController@update'])->name('user.update');
        });
        $api->group(['middleware' => 'api.auth'], function (Router $api) {
            $api->post('image', 'ImageController@store')->name('image.store');
            $api->post('mail', 'EmailController@show')->name('email.show');
            $api->group(['namespace' => 'Examination', 'prefix' => 'bank'], function (Router $api) {

                $api->get('question-tag', 'QuestionTagController@index')->name('question-tag.index');
                $api->get('question-tag/{slug}', 'QuestionTagController@show')->name('question-tag.show');
                $api->post('question-tag', 'QuestionTagController@store')->name('question-tag.store');
                $api->patch('question-tag/{id}', 'QuestionTagController@update')->name('question-tag.update');

                $api->get('question', 'QuestionController@index')->name('question.index');
                $api->get('question/{id}', 'QuestionController@show')->name('question.show');
                $api->post('question', 'QuestionController@store')->name('question.store');
                $api->patch('question/{id}', 'QuestionController@update')->name('question.update');

                $api->get('examination', 'ExaminationController@index')->name('question.index');
                $api->get('examination/{id}', 'ExaminationController@show')->name('question.show');
                $api->post('examination', 'ExaminationController@store')->name('question.store');
                $api->patch('examination', 'ExaminationController@update')->name('question.update');
            });
        });
    });
});