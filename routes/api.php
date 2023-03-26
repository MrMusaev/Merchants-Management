<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Merchants\CrudController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/v1')->group(function () {
    // Auth APIs
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])
        ->name('merchants.register');

    // Auth required routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Merchant routes
        Route::resource('merchants', CrudController::class)
            ->except(['create', 'edit']);
    });
});
