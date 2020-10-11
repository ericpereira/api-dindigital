<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/shit', function (Request $request) {
  return 'eae';
});

Route::get('/test', function () {
  return "Hello world";
});

//ROTAS DA API
Route::post('/store', [ProductController::class, 'store'])->name('products.store');
Route::put('/update', [ProductController::class, 'update'])->name('products.update');
Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
Route::get('/list', [ProductController::class, 'index'])->name('products.list');
