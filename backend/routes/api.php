<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
//--------MICROSOFT------------------------------------------
Route::group(['prefix' => '/auth', ['middleware' => 'throttle:20,5']], function() {
    Route::post('/login', [\App\Http\Controllers\LoginController::class, 'login']);
    Route::get('/login/{service}',  [\App\Http\Controllers\SocialLoginController::class, 'redirect']);
    Route::get('/login/{service}/callback', [\App\Http\Controllers\SocialLoginController::class, 'callback']);
});
//------------------------------------------------------------
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::get('/user-profile', 'AuthController@userProfile');


});

Route::name('Admin')
    ->prefix('users')
    ->middleware(['auth', 'can:accessdmin'])
    ->group(function () {


    });
Route::name('Admin')
    ->prefix('workspaces')
    ->middleware(['auth', 'can:accessdmin'])
    ->group(function () {

    });


Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/send-email/{id}', 'MailController@sendMail');
    Route::post('/send-helpEmail/', 'MailController@sendHelpEmail');


    Route::get('/postEvent/{id}', 'CalendarController@postEventToCalendar');

    Route::group(
        ['prefix' => 'zones'],
        function () {
            Route::get('/', 'ZoneController@index');
            Route::get('/{zone}', 'ZoneController@show');
            Route::post('/', 'ZoneController@store');
            Route::patch('/{zone}', 'ZoneController@update');
            Route::delete('/{zone}', 'ZoneController@destroy');

            Route::get('/{zone}/workspaces/', 'ZoneController@showWorkspaces');


        }
    );

    Route::group(
        ['prefix' => 'reservations'],
        function () {
            Route::get('/', 'ReservationController@index');
            Route::get('/{reservation}', 'ReservationController@show');
            Route::post('/', 'ReservationController@store');
            Route::patch('/{reservation}', 'ReservationController@update');
            Route::delete('/{reservation}', 'ReservationController@destroy');
        }

    );

    Route::group(
        ['prefix' => 'monitors'],
        function () {
            Route::get('/', 'MonitorController@index');
            Route::get('/{monitor}', 'MonitorController@show');
            Route::post('/', 'MonitorController@store');
            Route::patch('/{monitor}', 'MonitorController@update');
            Route::delete('/{monitor}', 'MonitorController@destroy');
        }

    );

    Route::group(
        ['prefix' => 'workspaces'],
        function () {
            Route::get('/', 'WorkspaceController@index');
            Route::get('/{workspace}', 'WorkspaceController@show');
            Route::post('/', 'WorkspaceController@store');
            Route::patch('/{workspace}', 'WorkspaceController@update');
            Route::delete('/{workspace}', 'WorkspaceController@destroy');
            Route::post('/{workspace}/reservation/', 'WorkspaceController@makeReservation');

        }

    );


    Route::group(
        ['prefix' => 'users'],
        function () {
            Route::get('/', 'UserController@index');
            Route::get('/{user}', 'UserController@show');
            Route::post('/', 'UserController@store');
            Route::patch('/{user}', 'UserController@update');
            Route::delete('/{user}', 'UserController@destroy');
        }

    );
});
