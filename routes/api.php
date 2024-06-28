<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\registercontroller;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\AmountCollectionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PostController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', [RegisterController::class, 'register']);
Route::post('/images', [ImageController::class, 'store']);
Route::get('/images/{name}', [ImageController::class, 'show']);
Route::get('/images', [ImageController::class, 'index']);
Route::post('/collect-amount', [AmountCollectionController::class, 'store']);
Route::get('/total-amount', [AmountCollectionController::class, 'getTotalAmount']);
Route::apiResource('expenses', ExpenseController::class);
Route::post('posts', [PostController::class, 'create']);

Route::middleware(['auth:sanctum', 'village'])->group(function () {
    Route::get('/village-data', [VillageDataController::class, 'index']);
});

Route::get('users', 'RegisterController@getUsers')->middleware('auth:api'); 
