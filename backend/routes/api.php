<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SampleController;
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

Route::prefix('promo')->group(function () {
  Route::post('/', [SampleController::class,'list']);
  Route::post('/get', [SampleController::class,'get']);
  Route::post('/create', [SampleController::class,'create']);
  Route::post('/update', [SampleController::class,'update']);
  Route::post('/delete', [SampleController::class,'delete']);
});
