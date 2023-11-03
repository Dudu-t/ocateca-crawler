<?php

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/create', '\App\Http\Controllers\CreateEmpresaController@handle');

Route::group(['prefix' => 'empresa'], function(){
    Route::get('/', 'App\Http\Controllers\ListAllEmpresasController@handle');
    Route::get('/search', 'App\Http\Controllers\SearchEmpresasController@handle');
    Route::patch('/update', 'App\Http\Controllers\UpdateEmpresasContactController@handle');
});
