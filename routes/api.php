<?php

use App\Http\Controllers\AuthControoler;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


Route::post('/register',[AuthControoler::class, 'register']);
Route::post('/login',[AuthControoler::class, 'login']);

Route::get('/logout',[AuthControoler::class, 'logout'])
->middleware('auth:sanctum');


Route::get('/products/search/{name?}',[ProductController::class, 'search']);
Route::apiResource('/products',ProductController::class);




