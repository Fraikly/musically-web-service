<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchSongsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SimilarSongsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('apiLogin');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::get('/unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');
    Route::delete('/logout', [AuthController::class, 'logout'])->name('auth.logout');
});


Route::get('/search', [SearchSongsController::class, 'search']);
Route::get('/get_similarities', [SimilarSongsController::class, 'index']);


