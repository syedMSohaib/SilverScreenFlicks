<?php

use App\Http\Controllers\Scrap\GoMovieController;
use App\Http\Controllers\Scrap\IndexesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'movies'], function() {

    Route::get('/scrap-go-movies', [GoMovieController::class, 'index']);

    Route::get('scrap-indexes', [IndexesController::class, 'index']);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
