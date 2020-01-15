<?php

//auth
Route::get('/login/{service}', 'SocialLoginController@redirect');
Route::get('/login/{service}/callback', 'SocialLoginController@callback');

Route::post('/auth/login', 'UserController@login');
Route::get('/auth/user', 'UserController@me');
Route::post('/auth/logout', 'UserController@logout');
Route::post('/auth/store', 'UserController@store');

//adminLoginController
Route::post('/admin-login', 'AdminLoginController');

//paypal
Route::post('/create-payment-stripe', 'StripeController');

//get ipUser
Route::get('/ip', 'IpController');

//cart
Route::get('/carts', 'CartController@index');
Route::post('/carts', 'CartController@store');
Route::put('/carts', 'CartController@update');
Route::delete('/carts', 'CartController@destroy');

//cartcheck
Route::post('/check-cart', 'CheckCartController');

Route::resource('categories', 'CategoryController');
Route::resource('products', 'ProductController');
Route::resource('products-admin', 'ProductAdminController');
Route::resource('orders', 'OrderController');
Route::resource('accounts', 'AccountController');
Route::resource('payment-methods', 'PaymentMethodController');
