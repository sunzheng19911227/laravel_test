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
//Route::get('/admin', 'Admin\IndexController@index');
// TEST同步
Route::get('/sync/sync_mall', 'SyncController@sync_mall');

// 后台管理
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function() {
	Route::get('/', 'IndexController@index');
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
	Route::post('/products/ajax_create_form', 'ProductController@ajax_create_form');
	Route::resource('/products', 'ProductController');

	Route::post('/product_sub/ajax_create_form', 'ProductSubController@ajax_create_form');
	Route::get('/product_sub/create/{id}', 'ProductSubController@create');
	Route::resource('/product_sub', 'ProductSubController');
	
	Route::resource('/category', 'CategoryController');
	Route::resource('/supplier', 'SupplierController');
	Route::resource('/brand', 'BrandController');

	Route::post('/property/check_status', 'AttrController@check_status');
	Route::resource('/property', 'AttrController');

	Route::get('/attr_value/create_value/{id}', 'AttrValueController@create_value');
	Route::resource('/attr_value', 'AttrValueController');

	Route::get('/attr_group/relevance/{id}', 'AttrGroupController@relevance');
	Route::put('/attr_group/relevance_handle', 'AttrGroupController@relevance_handle');
	Route::post('/attr_group/check_status', 'AttrGroupController@check_status');
	route::delete('/attr_group/detach/{id}/attr_group_id/{attr_group_id}', 'AttrGroupController@detach');
	Route::resource('/attr_group', 'AttrGroupController');

	Route::get('/option_group/relevance/{id}', 'OptionGroupController@relevance');
	Route::put('/option_group/relevance_handle', 'OptionGroupController@relevance_handle');
	Route::post('/option_group/check_status', 'OptionGroupController@check_status');
	route::delete('/option_group/detach/{id}/option_group_id/{option_group_id}', 'OptionGroupController@detach');
	Route::resource('/option_group', 'OptionGroupController');
});

//  营销渠道
Route::group(['prefix' => 'channel', 'namespace' => 'Channel', 'middleware' => 'auth'], function() {
	Route::resource('/channels', 'ChannelController');
});
