<?php

use App\Http\Controllers\Admin\Api\CategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['as' => 'admin.', 'prefix' => 'admin'], function () {
    Route::get('category',[CategoryController::class,'index'])->name('category.index');
    Route::post('category/create',[CategoryController::class,'store'])->name('category.store');
    Route::post('category/update/{id}',[CategoryController::class,'update'])->name('category.update');
    Route::get('category/show/{id}',[CategoryController::class,'show'])->name('category.show');
});
