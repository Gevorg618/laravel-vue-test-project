<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\LibraryController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware'=>['auth:api']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);

    Route::group(['prefix'=>'/books'], function () {
        Route::get('/', [BookController::class, 'index']);
        Route::post('/', [BookController::class, 'create']);
        Route::post('/search', [BookController::class, 'search']);
        Route::get('/{book}/like', [BookController::class, 'like']);
        Route::post('/{book}', [BookController::class, 'getOne']);
        Route::delete('/{book}', [BookController::class, 'delete']);
    });
    Route::group(['prefix'=>'/libraries'], function () {
        Route::get('/', [LibraryController::class, 'getOnlyLibraries']);
        Route::get('/books', [LibraryController::class, 'index']);
    });
});
