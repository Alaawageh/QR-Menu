<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\RestuarantController;
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
Route::apiResource('/user',UserController::class);

Route::post('login',[AuthController::class,'login'])->middleware('guest:sanctum');
Route::post('logout',[AuthController::class,'logout'])->middleware('auth:sanctum');

Route::prefix('branch')->middleware('auth:sanctum')->group(function() {
    Route::get('/',[BranchController::class,'index']);
    Route::get('/{branch}',[BranchController::class,'show'])->withoutMiddleware('auth:sanctum');
    Route::post('/',[BranchController::class,'store']);
    Route::patch('/{branch}',[BranchController::class,'update']);
    Route::delete('/{branch}',[BranchController::class,'destroy']);
    Route::get('/{branch}/qr',[BranchController::class,'getQrCode']);
    
    Route::prefix('{branch}/category')->group(function() {
        Route::get('/',[CategoryController::class,'index'])->name('categories')->withoutMiddleware('auth:sanctum');
        Route::get('/{category}',[CategoryController::class,'show'])->withoutMiddleware('auth:sanctum');
        Route::post('/',[CategoryController::class,'store']);
        Route::patch('/{category}',[CategoryController::class,'update']);
        Route::delete('/{category}',[CategoryController::class,'destroy']);
        Route::post('/{category}',[CategoryController::class,'changeAvailable']);
        Route::post('/{category}/editImage',[CategoryController::class,'editImage']);
        Route::delete('/{category}/destroyImage',[CategoryController::class,'destroyImage']);

        Route::prefix('/{category}/item')->group(function() {
            Route::get('/',[ItemController::class,'index'])->withoutMiddleware('auth:sanctum');
            Route::get('/{item}',[ItemController::class,'show'])->withoutMiddleware('auth:sanctum');
            Route::post('/',[ItemController::class,'store']);
            Route::patch('/{item}',[ItemController::class,'update']);
            Route::delete('/{item}',[ItemController::class,'destroy']);
            Route::post('/{item}',[ItemController::class,'changeAvailable']);
            Route::post('/{item}/editImage',[ItemController::class,'editImage']);
            Route::delete('/{item}/destroyImage',[ItemController::class,'destroyImage']);
        });
    });
    
});