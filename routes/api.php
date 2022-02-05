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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api'])->group(function ($router){
    Route::post('login','AuthController@login');
    Route::post('logout','AuthController@logout');
    Route::post('refresh','AuthController@refresh');
    Route::get('me','AuthController@me');
    Route::post('reg_product','ApiController@reg_product');
    Route::get('show_products','ApiController@show_products');
    Route::post('show_product','ApiController@show_product');
    Route::post('update_product','ApiController@update_product');
    Route::post('delete_product','ApiController@delete_product');
    Route::post('reg_user','ApiController@reg_user');
    Route::get('show_users','ApiController@show_users');
    Route::post('show_user','ApiController@show_user');
    Route::post('update_user','ApiController@update_user');
    Route::post('delete_user','ApiController@delete_user');
    Route::post('fill_user','ApiController@fill_user');
    Route::post('register','ApiController@register');
});
