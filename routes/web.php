<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if(Auth::check()){
        return redirect() -> route('products.index');
    } else {
        return redirect() -> route('login');
    }
});

Auth::routes();

Route::group(['middleware' => 'auth'], function(){
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::get('search', [App\Http\Controllers\ProductController::class, 'search'])->name('search');
});