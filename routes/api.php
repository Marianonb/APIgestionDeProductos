<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;

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
Route::get('productos', 'ProductoController@index');
Route::post('productos', 'ProductoController@store');
Route::get('productos/{id}', 'ProductoController@show');
Route::put('productos/{id}', 'ProductoController@update');
Route::delete('productos/{id}', 'ProductoController@destroy');
Route::put('productos/{id}/vender', 'ProductoController@vender');
Route::put('productos/{id}/actualizar-inventario', 'ProductoController@actualizarInventario');

