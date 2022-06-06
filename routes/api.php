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
Route::get('/usuarios','App\Http\Controllers\UserController@index'); //mostrar todos los usuarios
Route::get('/usuarios/{id}','App\Http\Controllers\UserController@show'); //mostrar un usuario
Route::post('/usuarios','App\Http\Controllers\UserController@store'); //crear usuario
Route::put('/usuarios/{id}','App\Http\Controllers\UserController@update'); //actualizar
Route::delete('/usuarios/{id}','App\Http\Controllers\UserController@destroy'); //borrar