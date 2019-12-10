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

Route::get('/', ["uses"=>"ProductsController@index", "as"=> "allProducts"]);

//Show all the products of the shop
Route::get('products', ["uses"=>"ProductsController@index", "as"=> "allProducts"]);

Route::get('cart/orderPaid/{paymentID}/{payerID}', ["uses"=>"Payment\PaymentsController@processPaymentData", "as"=> "processPaymentData"]);


//Route for category Deportes
Route::get('products/sports', ["uses"=>"ProductsController@sportsProducts", "as"=> "sportsProducts"]);

//Route for category Colchones
Route::get('products/mattresses', ["uses"=>"ProductsController@mattressesProducts", "as"=> "mattressesProducts"]);

//Route for category Vinos
Route::get('products/wines', ["uses"=>"ProductsController@winesProducts", "as"=> "winesProducts"]);

//complementsProducts
Route::get('products/complements', ["uses"=>"ProductsController@complementsProducts", "as"=> "complementsProducts"]);

//Url for search function
Route::get('search', ["uses"=>"ProductsController@searchProducts", "as"=> "searchProducts"]);

//Url for filter by price function
Route::get('filter', ["uses"=>"ProductsController@filterProducts", "as"=> "filterProducts"]);

//add to cart
Route::get('product/addToCart/{id}',['uses'=>'ProductsController@addProductToCart','as'=>'AddToCartProduct']);

//show all the items in the cart
Route::get('cart', ["uses"=>"ProductsController@showWholeCart", "as"=> "cartProducts"]);

//Delete a choosen item from the cart
Route::get('product/deleteItem/{id}',['uses'=>'ProductsController@deleteProductFromTheCart','as'=>'DeleFromCartProduct']);

//Increase quantity of a choosen product in the cart
Route::get('product/increaseChosenProduct/{id}',['uses'=>'ProductsController@increaseChosenProduct','as'=>'IncreaseChosenProduct']);

//Decrease quantity of a choosen product in the cart
Route::get('product/decreaseChosenProduct/{id}',['uses'=>'ProductsController@decreaseChosenProduct','as'=>'DecreaseChosenProduct']);

//Create order when user clicks on it
Route::get('cart/createOrder/', ["uses"=>"ProductsController@createOrder", "as"=> "createOrder"]);

Route::post('cart/createNewOrder/', ["uses"=>"ProductsController@createNewOrder", "as"=> "createNewOrder"]);

//Check Order page, to let the user review
Route::get('cart/checkOrder/', ["uses"=>"ProductsController@checkOrder", "as"=> "checkOrder"]);

//paymentmainpage route
Route::get('cart/paymentmainpage', ["uses"=> "Payment\PaymentsController@showPaymentData", 'as'=> 'showPaymentData']);



//Users
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Admin routes
//Admin products dashboard
Route::get('admin/products', ["uses"=>"Admin\AdminProductsController@index", "as"=> "adminShowProducts"])->middleware('restrictedToAdmin');

//Show Edit product panel
Route::get('admin/editProduct/{id}', ["uses"=>"Admin\AdminProductsController@editProduct", "as"=> "adminEditProduct"]);

//Show Edit image of a product panel
Route::get('admin/editProductImage/{id}', ["uses"=>"Admin\AdminProductsController@editProductImage", "as"=> "admineditProductImage"]);

//Update the image of a product
Route::post('admin/updateImage/{id}', ["uses"=>"Admin\AdminProductsController@updateImage", "as"=> "adminUpdateImage"]);

//Update the data of a product
Route::post('admin/updateProduct/{id}', ["uses"=>"Admin\AdminProductsController@updateProduct", "as"=> "adminUpdateProduct"]);

//Show create new product panel
Route::get('admin/createProduct', ["uses"=>"Admin\AdminProductsController@createProduct", "as"=> "adminCreateProduct"]);

//Create a new product, sendingthe data to save in our DB
Route::post('admin/sendCreateProduct', ["uses"=>"Admin\AdminProductsController@sendCreateProductData", "as"=> "adminSendCreateProduct"]);

//Delete a product
Route::get('admin/deleteProduct/{id}', ["uses"=>"Admin\AdminProductsController@deleteProduct", "as"=> "adminDeleteProduct"]);


//Admin orders dashboard
Route::get('admin/orders', ["uses"=>"Admin\AdminProductsController@showOrders", "as"=> "showOrders"])->middleware('restrictedToAdmin');

//Admin sales data
Route::get('admin/salesData', ["uses"=>"Admin\AdminProductsController@showProductData", "as"=> "showSalesData"])->middleware('restrictedToAdmin');

//Delete an order
Route::get('admin/deleteOrder/{id}', ["uses"=>"Admin\AdminProductsController@deleteOrder", "as"=> "adminDeleteOrder"]);

//Show Edit order panel
Route::get('admin/editOrder/{id}', ["uses"=>"Admin\AdminProductsController@editOrder", "as"=> "adminEditOrder"]);

//Update the data of an order
Route::post('admin/updateOrder/{id}', ["uses"=>"Admin\AdminProductsController@updateOrder", "as"=> "adminUpdateOrder"]);

//View the products for an specific order
Route::get('admin/viewOrder/{id}', ["uses"=>"Admin\AdminProductsController@viewOrder", "as"=> "adminViewOrder"]);





