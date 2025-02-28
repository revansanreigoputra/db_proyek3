<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route untuk register
Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);

// Route untuk login
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

// Route untuk login google
Route::post('/login/google', [App\Http\Controllers\Api\AuthController::class, 'loginGoogle']);

// Route untuk logout
Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:sanctum');

// route untuk mendapatkan events berdasarkan category_id
Route::get('/events', [App\Http\Controllers\Api\EventController::class, 'index']);

// route untuk mendapatkan semua event categories
Route::get('/event-categories', [App\Http\Controllers\Api\EventController::class, 'eventCategories']);

// route untuk mendapatkan detail event dan sku berdasarkan event_id
Route::get('/event/{event_id}', [App\Http\Controllers\Api\EventController::class, 'detail']);

// route untuk membuat order
Route::post('/order', [App\Http\Controllers\Api\OrderController::class, 'create'])->middleware('auth:sanctum');