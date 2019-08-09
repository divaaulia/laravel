<?php

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/main_content', function() {
    return view('main');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/categories', 'CategoriesController');
    Route::get('/table/categories', 'CategoriesController@dataTable')->name('table.categories');
    Route::get('/pdf/categories', 'CategoriesController@exportPdf');

    // Route::resource('/products', 'ProductsController');
    // Route::get('/table/products', 'ProductsController@dataTable')->name('table.products');
    // Route::get('/pdf/products', 'ProductsController@exportPdf');
    // Route::get('/search/products', 'ProductsController@loadCategories');
});
