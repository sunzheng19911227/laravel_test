<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('/home', 'HomeController@index');
// 后台首页
Route::get('/admin', 'Admin\IndexController@index');

// 后台管理
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
	Route::get('/admins/{id}/assign', 'AdminController@assign');
	Route::post('/admins/{id}/assign', 'AdminController@assign_update');
	Route::resource('/admins', 'AdminController');
	Route::resource('/menus', 'MenuController');

	Route::get('/roles/{id}/assign', 'RoleController@assign');
	Route::post('/roles/{id}/assign', 'RoleController@assign_update');
	Route::resource('/roles', 'RoleController');
});

//  商品管理
Route::group(['prefix' => 'product', 'namespace' => 'Product', 'middleware' => 'auth'], function() {
	Route::resource('/products', 'ProductController');
	Route::get('/product_sub/create/{id}', 'ProductSubController@create');
	Route::resource('/product_sub', 'ProductSubController');
	Route::resource('/category', 'CategoryController');
	Route::resource('/supplier', 'SupplierController');
	Route::resource('/brand', 'BrandController');
	Route::resource('/attr', 'AttrController');

	Route::get('/attr_value/create_value/{id}', 'AttrValueController@create_value');
	Route::resource('/attr_value', 'AttrValueController');
});
