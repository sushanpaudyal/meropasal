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

Route::get('/', 'IndexController@index')->name('indexpage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/products/{slug}', 'FrontController@products')->name('products');

Route::get('/product/{id}', 'FrontController@product')->name('single.products');

Route::post('product/get-product-price', 'ProductsController@getProductPrice');

Route::match(['get', 'post'], '/add-cart', 'CartController@addtoCart')->name('addtocart');

Route::match(['get', 'post'], '/cart', 'CartController@cart')->name('cart');

Route::get('/cart/delete-product/{id}', 'CartController@deleteCart')->name('delete.cart');

Route::get('/cart/update-quantity/{id}/{quantity}', 'CartController@updateCartQuantity')->name('update.cart');


//Coupons
Route::post('/cart/apply-coupon', 'CouponsController@applyCoupon')->name('apply.coupon');



//Route::get('/adminLogin', 'AdminController@login')->name('admin.login');
Route::match(['get', 'post'], '/adminLogin', 'AdminController@login')->name('admin.login');

Route::group(['middleware' => ['auth']], function(){
    Route::get('/admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
    Route::get('/admin/profile/{id}', 'AdminController@profile')->name('admin.profile');
    Route::post('/admin/update/profile/{id}', 'AdminController@update')->name('admin.update');


    Route::match(['get', 'post'], '/admin/add-category', 'CategoryController@addCategory')->name('category.add');
    Route::get('/admin/view-categories', 'CategoryController@viewCategories')->name('category.view');
    Route::match(['get', 'post'], '/admin/edit-category/{id}', 'CategoryController@editCategory')->name('category.edit');
    Route::match(['get', 'post'], '/admin/delete-category/{id}', 'CategoryController@deleteCategory')->name('category.delete');

//    Products Routes
    Route::match(['get', 'post'], 'admin/add-product', 'ProductsController@addProduct')->name('product.add');
    Route::get('/admin/view-products', 'ProductsController@viewProducts')->name('product.view');

    Route::match(['get', 'post'], '/admin/edit-product/{id}', 'ProductsController@editProduct')->name('product.edit');
    Route::get('/admin/delete-product/{id}', 'ProductsController@deleteProduct')->name('product.delete');

    Route::match(['get', 'post'], '/admin/add-attribute/{id}', 'ProductsController@addAttributes')->name('product.addattribute');

    Route::get('/admin/delete-attribute/{id}', 'ProductsController@deleteAttribute')->name('delete.attribute');

    Route::get('/admin/delete-product-image/{id}', 'ProductsController@deleteProductImage')->name('delete-productimage');


    Route::match(['get', 'post'], '/admin/add-images/{id}', 'ProductsController@addImages')->name('alt.image');

    Route::get('/admin/delete-alt-image/{id}', 'ProductsController@deleteAltImage')->name('alt.delete');

    Route::match(['get', 'post'], '/admin/edit-attribute/{id}', 'ProductsController@editAttributes')->name('edit.attribute');

    Route::match(['get', 'post'], '/admin/add-coupon', 'CouponsController@addCoupon')->name('add.coupon');
    Route::get('/admin/view-coupons', 'CouponsController@viewCoupons')->name('view.coupons');
    Route::match(['get', 'post'], '/admin/edit-coupon/{id}', 'CouponsController@editCoupon')->name('edit.coupon');

    Route::get('/admin/delete-coupon/{id}', 'CouponsController@deleteCoupon');
});


Route::get('/logout', 'AdminController@logout')->name('admin.logout');