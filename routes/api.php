<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('api')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::middleware('authMiddelware:user-api')->  post('profile', 'AuthController@getProfile');
    Route::middleware('authMiddelware:user-api')->  post('logout', 'AuthController@logout');

              ///////////////// products /////////////////

    Route::get('getProducts', 'ProductController@getProducts');
    Route::get('getProductsbyid', 'ProductController@getProdctById');
    Route::get('search', 'ProductController@Search');
    Route::get('addtocart', 'ProductController@addtoCart');
    Route::get('clearcart', 'ProductController@clearCart');
    Route::get('addtofavourite', 'ProductController@addtoFavourite');
    Route::get('clearfavourite', 'ProductController@clearFavourite');

    ///////////////// categories //////////////////////
    Route::get('getCategories', 'CategoryController@getCategories');
    Route::get('getProductsbycategories', 'CategoryController@getProductByCategories');



});
