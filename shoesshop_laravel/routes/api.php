<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
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

Route::controller(UserController::class)->group(function(){
    Route::get('/getAllUsers','index');
    Route::get('/getUserDetails/{id}','detail');
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::put('/updateUser/{id}','update');
});

Route::controller(ProfileController::class)->group(function(){
    Route::get('/getProfileDetails/{id}','detail');
    Route::put('/updateProfile/{id}','update');
});

Route::controller(ProductController::class)->group(function(){
    Route::get('/getAllProducts','index');
    Route::get('/getProductDetails/{id}','detail');
    Route::post('/insertProduct', 'create');
    Route::put('/updateProduct/{id}', 'update');
});

Route::controller(BrandController::class)->group(function(){
    Route::get('/getAllBrands','index');
    Route::get('/getBrandDetails/{id}','detail');
    Route::post('/insertBrand', 'create');
    Route::put('/updateBrand/{id}', 'update');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('/getAllCategories','index');
    Route::get('/getCategoryDetails/{id}','detail');
    Route::post('/insertCategory', 'create');
    Route::put('/updateCategory/{id}', 'update');
});

