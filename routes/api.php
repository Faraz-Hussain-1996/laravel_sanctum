<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\TaskController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::POST('/login', [AuthController::class,'login']);
Route::POST('/register', [AuthController::class,'register']);


Route::group(['middleware' => ['auth:sanctum']],function(){
    Route::POST('/logout', [AuthController::class,'logout']);
    Route::resource('/tasks', TaskController::class);
});