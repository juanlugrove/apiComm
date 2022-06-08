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
    Route::post('logout','App\HTTP\Controllers\AuthController@logout');
    Route::post('login','App\HTTP\Controllers\AuthController@login');
    Route::post('refresh','App\HTTP\Controllers\AuthController@refresh');
    Route::post('me','App\HTTP\Controllers\AuthController@me');
    Route::post('register','App\HTTP\Controllers\AuthController@register');
});


Route::group([
    'middleware' => 'api',
], function ($router){
    // Route::get('/usuarios','App\Http\Controllers\UserController@index'); //mostrar todos los usuarios
    Route::get('/usuarios/{id}','App\Http\Controllers\UserController@show'); //mostrar un usuario
    // Route::post('/usuarios','App\Http\Controllers\UserController@store'); //crear usuario
    Route::put('/usuarios/{id}','App\Http\Controllers\UserController@update'); //actualizar
    Route::delete('/usuarios/{id}','App\Http\Controllers\UserController@destroy'); //borrar

    //TEAM
    Route::post('/team','App\Http\Controllers\TeamController@store');
    Route::get('/team/{id}','App\Http\Controllers\TeamController@show');
    Route::put('/team/{id}','App\Http\Controllers\TeamController@update');
});