<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AboutController;

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

// password protected 
Route::resource('plants', PlantController::class)->middleware('auth:sanctum');
Route::get('plants/search/{searchTerm}', [PlantController::class, 'searchText'])->middleware('auth:sanctum');
Route::get('plants/lowstock/{quantity}', [PlantController::class, 'lowStock'])->middleware('auth:sanctum');
Route::put('plants/addstock/{id}', [PlantController::class, 'update'])->middleware('auth:sanctum');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// public route
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::resource('about', AboutController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user(++ ,///////

);
});
