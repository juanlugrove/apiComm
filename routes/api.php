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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router){
    Route::post('logout','App\Http\Controllers\AuthController@logout');
    Route::post('login','App\Http\Controllers\AuthController@login');
    Route::post('refresh','App\Http\Controllers\AuthController@refresh');
    Route::post('me','App\Http\Controllers\AuthController@me');
    Route::post('register','App\Http\Controllers\AuthController@register');
    Route::get('/username/{username}','App\Http\Controllers\AuthController@nombreUsado'); //borrar
    Route::get('/mail/{mail}','App\Http\Controllers\AuthController@correoUsado'); //borrar
});


Route::group([
    'middleware' => 'api',
], function ($router){
    // Route::get('/usuarios','App\Http\Controllers\UserController@index'); //mostrar todos los usuarios
    Route::get('/usuarios','App\Http\Controllers\UserController@show'); //mostrar un usuario
    // Route::post('/usuarios','App\Http\Controllers\UserController@store'); //crear usuario
    Route::put('/usuarios/{id}','App\Http\Controllers\UserController@update'); //actualizar
    Route::delete('/usuarios/{id}','App\Http\Controllers\UserController@destroy'); //borrar

    //TEAM
    Route::post('/team','App\Http\Controllers\TeamController@store');
    Route::get('/team','App\Http\Controllers\TeamController@index');
    Route::get('/team/{id}','App\Http\Controllers\TeamController@show');
    Route::put('/team/{id}','App\Http\Controllers\TeamController@update');
    Route::delete('/team/{id}','App\Http\Controllers\TeamController@destroy');

    //TEAMUSERS
    Route::get('/teamUsers','App\Http\Controllers\TeamuserController@index');
    Route::get('/teamUsers/{idTeam}','App\Http\Controllers\TeamuserController@usersTeam');
    Route::post('/teamUsers','App\Http\Controllers\TeamuserController@store');
    Route::delete('/teamUsers','App\Http\Controllers\TeamuserController@salir');
    Route::delete('/teamUsers/{idUser}','App\Http\Controllers\TeamuserController@destroy');
    
    //USERSEARCHTEAM
    Route::get('/userST','App\Http\Controllers\UsersearchteamController@index');
    Route::get('/userST/{id}','App\Http\Controllers\UsersearchteamController@show');
    Route::post('/userST','App\Http\Controllers\UsersearchteamController@store');
    Route::delete('/userST','App\Http\Controllers\UsersearchteamController@destroy');
    
    //TEAMSEARCHUSER
    Route::get('/teamSU','App\Http\Controllers\TeamsearchuserController@index');
    Route::get('/teamSU/{id}','App\Http\Controllers\TeamsearchuserController@show');
    Route::post('/teamSU','App\Http\Controllers\TeamsearchuserController@store');
    Route::delete('/teamSU/{id}','App\Http\Controllers\TeamsearchuserController@destroy');
    
    //NOTIFICATIONS
    Route::get('/notifications','App\Http\Controllers\NotificationController@index');
    Route::post('/notifications','App\Http\Controllers\NotificationController@store');
    // Route::get('/notifications/{id}','App\Http\Controllers\NotificationController@show');
    Route::post('/notifications/accept/{id}','App\Http\Controllers\NotificationController@acceptNotification');
    Route::post('/notifications/decline/{id}','App\Http\Controllers\NotificationController@declineNotification');

});