<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\controllers\AuthController;
use App\Http\Middleware\JwtMiddleware;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});


Route::apiResource('/students', StudentController::class);

Route::withoutMiddleware('jwtAuth')->group(function () {
  Route::post('login', [AuthController::class, 'login']);
});
Route::get('user', [AuthController::class, 'getUser']);
Route::post('logout', [AuthController::class, 'logout']);

