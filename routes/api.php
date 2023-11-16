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
Route::post('login', '\App\Http\Controllers\API\UserController@login');
Route::post('register', '\App\Http\Controllers\API\Auth\UserController@register');
Route::get('/auth/google', '\App\Http\Controllers\API\Auth\GoogleController@redirect')->name('auth.google');
Route::get('/auth/google/callback', '\App\Http\Controllers\API\Auth\GoogleController@callback');
Route::group(['middleware' => 'auth:api'], function(){
    Route::post('details', '\App\Http\Controllers\API\UserController@details');
    Route::get('/gpt/chat', '\App\Http\Controllers\API\AIModels\GptController@index');
    Route::post('/gpt/chat', '\App\Http\Controllers\API\AIModels\GptController@chat')->name('chat');
    Route::get('/sdxl/chat', '\App\Http\Controllers\API\AIModels\SdxlController@index');
    Route::post('/sdxl/chat', '\App\Http\Controllers\API\AIModels\SdxlController@chat')->name('image');
    Route::resource('networks', \App\Http\Controllers\API\Network\NetworkController::class);
});
