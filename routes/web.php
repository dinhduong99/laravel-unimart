<?php

use App\Http\Controllers\AdminContactController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('storagelink', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});
Route::get('queuework', function () {
    \Illuminate\Support\Facades\Artisan::call('queue:work --stop-when-empty');
});
Route::get('/', 'HomeController@index');
Route::post('update_ajax', 'CartController@update_ajax')->name('cart.update-ajax');
Route::get('danh-muc/{slug}', 'CatProductController@cat_product')->name('cat-product');
Route::get('san-pham/{slug}.html', 'DetailProductController@index')->name('detail-product');
Route::get('san-pham/', 'HomeController@product_all')->name('product-all');
Route::get('gio-hang.html', 'CartController@index');
Route::post('them-san-pham/{slug}', 'CartController@add')->name('cart.add');
Route::post('add-cart-ajax', 'CartController@add_ajax')->name('cart.add-ajax');
Route::post('remove-ajax', 'CartController@remove_ajax')->name('cart.remove-ajax');
Route::get('delete-all', 'CartController@delete_all');
Route::get('thanh-toan.html', 'CheckoutController@index');
Route::post('select-address', 'CheckoutController@select_address');
Route::post('store', 'CheckoutController@store');
Route::get('thong-bao-don-hang.html', 'CheckoutController@infor_order');
Route::get('send-mail', 'OrderMailController@sendmail');
Route::post('tim-kiem.html', 'SearchController@index')->name('search');
Route::get('search-product', 'SearchController@ajax_search');
Route::get('mua-ngay/{slug}', 'CartController@buy_now')->name('buy-now');
Route::get('tin-cong-nghe', 'PostController@index');
Route::get('tin-cong-nghe/{slug}.html', 'PostController@detail')->name('post.detail');
Route::get('tin-cong-nghe/danh-muc/{slug}', 'PostController@cat_post')->name('post.cat');
Route::get('lien-he.html', 'ContactController@index');
Route::post('lien-he/store', 'ContactController@store');
Route::get('thong-bao-lien-he.html', 'ContactController@contact_success');
Route::get('gioi-thieu.html', 'HomeController@intro');
// Route::get('loc-san-pham', 'SearchController@product_filter')->name('product_filter');
// Route::get('thong-bao-don-hang', 'CheckoutController@order_success');
// Route::get('xoa-san-pham/{rowId}', 'CartController@remove')->name('cart.remove');

Auth::routes();
// Route::get('/home', 'HomeController@index')->name('home');


Route::middleware('auth')->group(function () {

    //Dashboard
    Route::get('dashboard', 'DashboardController@show');
    Route::get('admin', 'DashboardController@show');
    //User
    Route::get('admin/user/list', 'AdminUserController@list');
    Route::get('admin/user/add', 'AdminUserController@add');
    Route::post('admin/user/store', 'AdminUserController@store');
    Route::get('admin/user/disable/{id}', 'AdminUserController@disable')->name('disable-user');
    Route::get('admin/user/delete/{id}', 'AdminUserController@delete')->name('delete-user');
    Route::post('admin/user/action', 'AdminUserController@action');
    Route::get('admin/user/edit/{id}', 'AdminUserController@edit')->name('edit.user');
    Route::post('admin/user/update/{id}', 'AdminUserController@update')->name('update.user');

    //Product
    Route::get('admin/product/list', 'AdminProductController@list');
    Route::get('admin/product/list/stocking', 'AdminProductController@product_stocking');
    Route::get('admin/product/list/out-of-stock', 'AdminProductController@product_out_of_stock');
    Route::get('admin/product/list/pending', 'AdminProductController@product_pending');
    Route::get('admin/product/list/trash', 'AdminProductController@product_trash');
    Route::get('admin/product/add', 'AdminProductController@add');
    Route::post('admin/product/store', 'AdminProductController@store');
    Route::get('admin/product/edit/{id}', 'AdminProductController@edit')->name('edit.product');
    Route::post('admin/product/update/{id}', 'AdminProductController@update')->name('update.product');
    Route::get('admin/product/disable/{id}', 'AdminProductController@disable')->name('disable.product');
    Route::get('admin/product/delete/{id}', 'AdminProductController@delete')->name('delete.product');
    Route::post('admin/product/action', 'AdminProductController@action');
    Route::get('admin/product/color', 'AdminProductController@color');
    Route::post('admin/product/color_add', 'AdminProductController@color_add');
    Route::get('admin/product/color_delete/{id}', 'AdminProductController@color_delete')->name('color_delete');

    //Cat_parent
    Route::get('admin/product/cat_parent/list', 'AdminProductController@cat_parent_list');
    Route::post('admin/product/cat_parent/add', 'AdminProductController@cat_parent_add');
    Route::post('admin/product/slug', 'AdminProductController@slug')->name('slug.product');
    Route::get('admin/product/cat_parent/delete/{id}', 'AdminProductController@cat_parent_delete')->name('cat_parent_delete');

    //Cat
    Route::get('admin/product/cat/list', 'AdminProductController@cat');
    Route::post('admin/product/cat/add', 'AdminProductController@cat_add');
    Route::get('admin/product/cat/delete/{id}', 'AdminProductController@delete_cat')->name('delete_cat');

    //Cat_pending
    Route::get('admin/product/cat_pending/list', 'AdminProductController@cat_pending');
    Route::get('admin/product/cat_pending/delete/{id}', 'AdminProductController@cat_pending_delete')->name('cat_pending_delete');
    Route::get('admin/product/cat_pending/edit/{id}', 'AdminProductController@cat_pending_edit')->name('cat_pending_edit');
    Route::post('admin/product/cat_pending/update/{id}', 'AdminProductController@cat_pending_update')->name('cat_pending_update');

    //Slider
    Route::get('admin/slider/list', 'AdminSliderController@list');
    Route::get('admin/slider/list/slider-pending', 'AdminSliderController@pending');
    Route::get('admin/slider/list/slider-trash', 'AdminSliderController@trash');
    Route::get('admin/slider/add', 'AdminSliderController@add');
    Route::post('admin/slider/store', 'AdminSliderController@store');
    Route::get('admin/slider/disable/{id}', 'AdminSliderController@disable')->name('disable_slider');
    Route::get('admin/slider/delete/{id}', 'AdminSliderController@delete')->name('delete_slider');
    Route::post('admin/slider/action', 'AdminSliderController@action');
    Route::get('admin/slider/edit/{id}', 'AdminSliderController@edit')->name('edit_slider');
    Route::post('admin/slider/update/{id}', 'AdminSliderController@update')->name('update_slider');

    //Order
    Route::get('admin/order/list', 'AdminOrderController@list');
    Route::get('admin/order/list/detail/{id}', 'AdminOrderController@detail')->name('detail.order');
    Route::post('admin/order/list/order_status/{id}', 'AdminOrderController@order_status')->name('detail.order_status');
    Route::get('admin/order/list/disable/{id}', 'AdminOrderController@disable')->name('order.disable');
    Route::get('admin/order/list/delete/{id}', 'AdminOrderController@delete')->name('order.delete');
    Route::get('admin/order/list/order-complete', 'AdminOrderController@order_complete');
    Route::get('admin/order/list/order-delivering', 'AdminOrderController@order_delivering');
    Route::get('admin/order/list/order-processing', 'AdminOrderController@order_processing');
    Route::get('admin/order/list/order-cancel', 'AdminOrderController@order_cancel');
    Route::get('admin/order/list/order-trash', 'AdminOrderController@order_trash');
    Route::post('admin/order/action', 'AdminOrderController@action');
    Route::get('admin/order/loyal-customer', 'AdminOrderController@loyal_customer');
    //Post
    Route::get('admin/post/cat/list', 'AdminPostController@cat');
    Route::post('admin/post/cat/add', 'AdminPostController@cat_add');
    Route::get('admin/post/add', 'AdminPostController@add');
    Route::post('admin/post/store', 'AdminPostController@store');
    Route::get('admin/post/list', 'AdminPostController@list');
    Route::get('admin/post/list/post-approved', 'AdminPostController@approved');
    Route::get('admin/post/list/post-pending', 'AdminPostController@pending');
    Route::get('admin/post/list/post-trash', 'AdminPostController@trash');
    Route::get('admin/post/edit/{id}', 'AdminPostController@edit')->name('post.edit');
    Route::post('admin/post/update/{id}', 'AdminPostController@update')->name('post.update');
    Route::get('admin/post/disable/{id}', 'AdminPostController@disable')->name('post.disable');
    Route::get('admin/post/delete/{id}', 'AdminPostController@delete')->name('post.delete');
    Route::post('admin/post/action', 'AdminPostController@action');

    //Ads
    Route::get('admin/ads/add', 'AdminAdsController@add');
    Route::post('admin/ads/store', 'AdminAdsController@store');
    Route::get('admin/ads/list', 'AdminAdsController@list');
    Route::get('admin/ads/list/ads-pending', 'AdminAdsController@ads_pending');
    Route::get('admin/ads/list/ads-trash', 'AdminAdsController@ads_trash');
    Route::get('admin/ads/delete/{id}', 'AdminAdsController@delete')->name('delete_ads');
    Route::get('admin/ads/disable/{id}', 'AdminAdsController@disable')->name('disable_ads');
    Route::get('admin/ads/edit/{id}', 'AdminAdsController@edit')->name('edit_ads');
    Route::post('admin/ads/update/{id}', 'AdminAdsController@update')->name('update_ads');
    Route::post('admin/ads/action', 'AdminAdsController@action');

    //Contact
    Route::get('admin/contact/list', 'AdminContactController@list');
    Route::get('admin/contact/list/contact-approved', 'AdminContactController@contact_approved');
    Route::get('admin/contact/list/contact-pending', 'AdminContactController@contact_pending');
    Route::get('admin/contact/list/contact-trash', 'AdminContactController@contact_trash');
    Route::get('admin/contact/edit/{id}', 'AdminContactController@edit')->name('contact.edit');
    Route::get('admin/contact/disable/{id}', 'AdminContactController@disable')->name('contact.disable');
    Route::get('admin/contact/delete/{id}', 'AdminContactController@delete')->name('contact.delete');
    Route::post('admin/contact/action', 'AdminContactController@action');
    Route::post('admin/contact/update/{id}', 'AdminContactController@update_status')->name('contact.update');

    //Page
    Route::get('admin/page/add', 'AdminPageController@add');
    Route::post('admin/page/store', 'AdminPageController@store');
    Route::get('admin/page/list', 'AdminPageController@list');
    Route::get('admin/page/list/page-pending', 'AdminPageController@pending');
    Route::get('admin/page/list/page-trash', 'AdminPageController@trash');
    Route::get('admin/page/disable/{id}', 'AdminPageController@disable')->name('page.disable');
    Route::get('admin/page/delete/{id}', 'AdminPageController@delete')->name('page.delete');
    Route::get('admin/page/edit/{id}', 'AdminPageController@edit')->name('page.edit');
    Route::post('admin/page/update/{id}', 'AdminPageController@update')->name('page.update');
    Route::post('admin/page/action', 'AdminPageController@action');
    Route::post('admin/page/slug', 'AdminPageController@slug')->name('slug.page');

    Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['auth']], function () {
        \UniSharp\LaravelFilemanager\Lfm::routes();
    });
});
