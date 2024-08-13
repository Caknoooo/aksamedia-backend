<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SQLController;
use App\Http\Controllers\UserController;
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

Route::post('/register', [AdminController::class, 'register']);
Route::post('/login', [AdminController::class, 'login']);

Route::middleware(['iam'])->group(
  function () {
    Route::get('/me', [AdminController::class, 'me']);
    Route::post('/logout', [AdminController::class, 'logout']);

    // Employee
    Route::post('/employees', [EmployeeController::class, 'create']);
    Route::put('/employees/{id}', [EmployeeController::class, 'update']);
    Route::delete('/employees/{id}', [EmployeeController::class, 'delete']);
    Route::get('/employees', [EmployeeController::class, 'index']);

    // Division
    Route::get('/divisions', [DivisionController::class, 'index']);
  }
);

Route::get('/nilaiST', [SQLController::class, 'nilaiST']);
Route::get('/nilaiRT', [SQLController::class, 'nilaiRT']);
