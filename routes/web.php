<?php

use App\Http\Controllers\SimilarSongsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\SearchSongsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes();

Route::middleware('guest')->group(function () {
    Route::get('/', [MainController::class, 'index']);
});
Route::get('/home', [HomeController::class, 'index']);

Route::get('/search', SearchSongsController::class);
Route::get('/get_similarities', SimilarSongsController::class);

Route::middleware('auth')->group(function (){

});


