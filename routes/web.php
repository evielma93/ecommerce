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
	return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/calculaEdad/{fecha?}/','ClientController@calculaEdad')->name('calculaEdad');

Route::get('/plantilla', function () {
	return view('layouts.plantilla');
})->name('plantilla');


Route::get('/shop', 'ProductController@index')->name('shop');
Route::get('products/image/{filename}','ProductController@getImageProduct')->name('products.image');
Route::get('/shop','ProductController@index')->name('shop');
Route::post("product/{id}/add","ProductController@addToCart")->name("product.add");
Route::get("product/delete/{id}","ProductController@deleteFromCart")->name("product.delete");
Route::get("/cart/","ProductController@shopShow")->name('shop.cart');

/* Pagos */
Route::post('/payments/pay', 'PaymentController@pay')->name('pay');
Route::get('/payments/approval', 'PaymentController@approval')->name('approval');
Route::get('/payments/cancelled', 'PaymentController@cancelled')->name('cancelled');
Route::post('/payments/payTransfer/{data?}', 'PaymentController@payTransfer')->name('payTransfer');

						/* RUTAS PARA LOS CLIENTES */
Route::get("/registerCli","ClientController@create")->name('registerCli');
Route::group(["prefix" => "client"], function(){
	Route::post("/store","ClientController@store")->name('clients.store');
});
					/* FIN DE LAS RUTAS PARA LOS CLIENTES */

Route::group(["middleware" => "auth"], function () {
	Route::get("credit-card", 'BillingController@creditCardForm')
	->name("billing.credit_card_form");
	Route::post("credit-card", 'BillingController@processCreditCardForm')
	->name("billing.process_credit_card");

	Route::group(["prefix" => "orders"], function () {
		Route::get("/", "OrderController@index")->name("orders.index");
		Route::post("/", "OrderController@process")->name("orders.process");
		Route::get("/invoice/{invoice}", "OrderController@invoice")->name("orders.invoice");
		Route::post("/to_cart/{id}", "OrderController@toCart")->name("orders.to_cart");
		Route::get("/{id}", "OrderController@show")->name("orders.detail");
	});

	Route::group(["prefix" => "course"], function () {
		Route::get("/{id}/start", "CourseController@start")->name("course.start");
	});






});