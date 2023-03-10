<?php

use App\Http\Controllers\KeywordController;
use App\Http\Controllers\TokenController;
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

Route::post('/token', TokenController::class . '@create')->name('token');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::get('/keywords', KeywordController::getMethodName('index'))->name('keyword.index');
    Route::post('/keywords', KeywordController::getMethodName('create'))->name('keyword.create');
    Route::post('/keywords/csv', KeywordController::getMethodName('upload'))->name('keyword.upload');
    Route::get('/keywords/{id}', KeywordController::getMethodName('show'))->name('keyword.show');
});
