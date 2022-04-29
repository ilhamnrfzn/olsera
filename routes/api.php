<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;// manggil controller sesuai bawaan laravel 8
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::post('logout', 'AuthController@logout');

    Route::prefix('tax')->group(function(){
        Route::get('/','TaxController@read');
        Route::post('/add','TaxController@create');
        Route::post('/edit','TaxController@update');
        Route::delete('/delete','TaxController@delete');
    });

    Route::prefix('item')->group(function(){
        Route::get('/','ItemController@read');
        Route::post('/add','ItemController@create');
        Route::post('/edit','ItemController@update');
        Route::delete('/delete','ItemController@delete');
    });

    Route::prefix('itemwithtax')->group(function(){
        Route::post('/addtaxtoitem','ItemWithTaxController@addtaxtoitem');
        Route::post('/edittaxtoitem','ItemWithTaxController@edittaxitem');
        Route::get('/','ItemWithTaxController@read');
    });
});