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

/*Authentication */
Auth::routes();
Route::post('/attempt_registration', 'Auth\RegisterController@attempt_registration');
Route::get('/attempt_activation', 'Auth\RegisterController@attempt_activation');
Route::get('/logout', 'Auth\LoginController@logout'); //The default Auth system defines a post request for logout. I believe a get is more appropriate

/*Admin section*/
/*
Route::group([], function(){
	Route::get('admin', 'AdminController@login');
	Route::post('admin', 'AdminController@index');
	Route::get('admin/managebook/{action}', 'AdminController@managebook');
	Route::post('admin/managebook', 'AdminController@storebook');
	Route::get('admin/order', 'AdminController@order');
	Route::get('admin/storekeeper', 'AdminController@storekeeper');
	Route::get('admin/transaction', 'AdminController@transaction');
	Route::get('admin/category/{category}', 'AdminController@category');
});
*/

/*AJAX requests */
Route::get('getbooks/{category}', 'BookstoreController@getBooks');
Route::get('getJSONfile', 'BookstoreController@getJSONfile');
Route::post('testing', 'BookstoreController@testing');
Route::get('getBookList', 'BookstoreController@getBookList');
Route::get('db/suggest', 'BookstoreController@suggest');
Route::get('book/search', 'BookstoreController@search');

/*Shopping cart Mostly AJAX request*/
Route::get('cart/book/{id}', 'CartController@addToCart');
Route::get('cart/get','CartController@getCart');
Route::get('cart/empty','CartController@emptyCart');
Route::get('cart/checkout', 'CartController@checkout');
Route::get('cart/delete/{id}','CartController@deleteCart');
Route::post('cart/update', 'CartController@updateCart');

/*Payment System*/
Route::group([], function(){
	Route::get('payment/process', 'PaymentController@process');
	Route::post('payment/notify', 'PaymentController@notify');
	Route::get('payment/success', 'PaymentController@success');
	Route::get('payment/canel', 'PaymentController@cancel');
});



/*Traditional request*/
Route::get('/', 'BookstoreController@index');
Route::get('book/{id}','BookstoreController@book');
Route::get('{field}', 'BookstoreController@field');
Route::get('{field}/{subject}', 'BookstoreController@subject');

