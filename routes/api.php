<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\AuthController;
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

Route::get('/test', function () {
  return "Hello world";
});

//ROTAS DE USUÁRIO
Route::group([
  'middleware' => 'api',
  'prefix' => 'auth' ], function ($router) {

  Route::post('login', [AuthController::class, 'login']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('refresh', [AuthController::class, 'refresh']);
  Route::post('me', [AuthController::class, 'me']);
});
  
//ROTAS CRUD
Route::group([
  'middleware' => ['api', 'apiJwt'], ], function ($router) {

  Route::post('/store', [ProductController::class, 'store'])->name('products.store');
  Route::post('/update', [ProductController::class, 'update'])->name('products.update');
  Route::delete('/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
  Route::get('/list', [ProductController::class, 'index'])->name('products.list');
  Route::get('/last', [ProductController::class, 'last'])->name('products.last');
});

