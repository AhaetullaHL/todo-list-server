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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::post('login','\App\Http\Controllers\AuthController@login');
Route::post('register','\App\Http\Controllers\AuthController@register');

Route::group(['middleware' => 'auth.jwt'],function() {
    Route::get('logout', '\App\Http\Controllers\AuthController@logout');
    Route::get('tables/getContent/{table}', '\App\Http\Controllers\TableController@getContent');
    Route::resource('tables', '\App\Http\Controllers\TableController');
    Route::resource('groups', '\App\Http\Controllers\GroupController');
    Route::resource('todos', '\App\Http\Controllers\TodoController');
    Route::resource('categories', '\App\Http\Controllers\CategoryController');
    Route::resource('todoCategories', '\App\Http\Controllers\todoCategoryController');
});
