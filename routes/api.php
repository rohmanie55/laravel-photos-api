<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PhotoController;
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

Route::group(['prefix'=>'v1'], function(){

    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'store')->name('auth.login');
        Route::post('/register', 'register')->name('auth.register');
        
        Route::middleware('auth:api')->group(function () {
            Route::get('/user', 'user')->name('auth.user');
            Route::post('/logout', 'logout')->name('auth.logout');
        });
    });

    Route::controller(PhotoController::class)->group(function () {
        Route::get('/photos', 'index')->name('photo.index');
        Route::get('/photos/{photo}', 'store')->name('photo.show');

        Route::middleware('auth:api')->group(function () {
            Route::post('/photos', 'store')->name('photo.store');
            Route::put('/photos/{photo}', 'update')->name('photo.update');
            Route::delete('/photos/{photo}', 'destroy')->name('photo.destroy');
            Route::post('/photos/{photo}/like', 'like')->name('photo.like');
            Route::post('/photos/{photo}/unlike', 'unlike')->name('photo.unlike');
        });
    });
});
