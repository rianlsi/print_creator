<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ZakekeController;
use Illuminate\Support\Facades\Route;

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [ProductController::class, 'list'])->name('product.list');
Route::get('/product/{id}/detail', [ProductController::class, 'show'])->name('product.detail');

//API Section
// Route to get Zakeke access token
Route::get('/zakeke/token', [ZakekeController::class, 'getAccessToken']);

// Route to send product data to Zakeke
Route::post('/zakeke/send-product', [ZakekeController::class, 'sendProductToZakeke']);

// Route to fetch all products (for testing)
Route::get('/products', [ProductController::class, 'jlist']);
