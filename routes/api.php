<?php

use App\Http\Controllers\GenreController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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


Route::group(['middleware' => ['sessions']], function () {

    Auth::routes();
    Route::post('/email/exists', [HomeController::class, 'emailExist']);
    Route::post('/password/check-code', [HomeController::class, 'checkIfCodeExist']);

});

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('/', [HomeController::class, 'index']);
    Route::get('/profile', [HomeController::class, 'index']);
    Route::post('/profile', [HomeController::class, 'update']);
    Route::get('logout', [HomeController::class, 'doLogout']);
    Route::post('change-password', [HomeController::class, 'changePassword']);

    // Genre
    Route::get('genre', [GenreController::class, 'index'])->name('genre');

    //Movies
    Route::get('movies/search', [MovieController::class, 'search']);
    Route::get('movies/trending', [MovieController::class, 'trending']);
    Route::get('movies/upcoming', [MovieController::class, 'upcoming']);
    Route::get('movies/{tmdb}/recommendations', [MovieController::class, 'recommendations']);
    Route::get('movies/{tmdb}/similar', [MovieController::class, 'similar']);
    Route::apiResource('movies', MovieController::class);

});
