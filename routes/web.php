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

Route::get('/sitemap.xml', function () {
    include public_path() . '/sitemap.xml';
});
Route::group(['namespace' => 'Backend'], function () {
    Route::name('admin.')->prefix('admin')->group(function () {
        Auth::routes();
    });
});

//login
Route::group(['prefix'=>'admin', 'namespace'=>'Backend' ],function(){
    Route::get('/','LoginController@showLoginForm');
    Route::get('login','LoginController@showLoginForm')->name('login');
    Route::post('login','LoginController@login');
});


Route::group(['middleware' => array('auth'), 'namespace' => 'Backend'], function () {
    Route::name('admin.')->prefix('admin')->group(function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('xem-thong-bao', 'DashboardController@seenNotification')->name('seenNotification');
        Route::get('doc-thong-bao', 'DashboardController@readNotification')->name('readNotification');
        Route::resource('users', 'UserController');
        Route::resource('product', 'ProductController');
        Route::get('products-show', 'ProductController@anyDatatables')->name('datatable_product');
        Route::get('payProductForEditor', 'ProductController@payProductForEditor')->name('payProductForEditor');
        Route::resource('categories', 'CategoryController');
        Route::resource('tags', 'TagController');
        // Route::resource('productTags', 'ProductTagController');
        Route::get('site-map', 'DashboardController@siteMap');
        Route::get('upload-image', 'DashboardController@uploadImage');
        Route::post('upload-image', 'DashboardController@uploadImage');
        // Route::post('comments/read', 'CommentController@read');
        // Route::resource('comments', 'CommentController');
        // Route::post('replies/read', 'ReplyController@read');
        // Route::resource('replies', 'ReplyController');
        Route::get('news/update-canonical', 'NewsController@updateCanonical');
        Route::resource('news', 'NewsController');
        Route::get('news-show', 'NewsController@anyDatatables')->name('datatable_news');
        Route::get('payPostForEditor', 'NewsController@payPostForEditor')->name('payPostForEditor');
        Route::resource('newsCategories', 'NewsCategoryController');
        Route::resource('providers', 'ProviderController');
        Route::get('product/{id}/rating', 'ProductController@ratingSeeding');
        Route::post('product/{id}/rating', 'ProductController@ratingSeeding');
        Route::resource('pages', 'PageController');

        Route::resource('contacts', 'ContactController');
        Route::get('contact-advisor', 'ContactController@listAdvisorContact')->name('contact-advisor');
        Route::get('contact-remarketing', 'ContactController@listRemarketingContact')->name('contact-remarketing');
        Route::get('contact-remarketing-done', 'ContactController@listRemarketingContactDone')->name('contact-remarketing-done');
        Route::get('contact-advisor-remarketing', 'ContactController@listAdvisorRemarketingContact')->name('contact-advisor-remarketing');
        Route::get('contact-advisor-remarketing-done', 'ContactController@listAdvisorRemarketingContactDone')->name('contact-advisor-remarketing-done');
        Route::get('contact-advisor', 'ContactController@listAdvisorContact')->name('contact-advisor');
        Route::get('show-contact-advisor/{contact}', 'ContactController@editAdvisorContact')->name('show-contact-advisor');
        Route::post('update-contact-advisor', 'ContactController@updateAdvisorContact')->name('updateContactAdvisor');
        Route::post('create-appointment', 'ContactController@createAppointment')->name('create-appointment');

        Route::resource('trackingitems', 'TrackingItemController');

        Route::get('show-order-stocker/{order}', 'OrderController@showOrderForStocker')->name('showOrderStocker');
        Route::get('orders', 'OrderController@listOrder')->name('orderAdmin');
        Route::delete('order/{order}', 'OrderController@deleteOrder')->name('orderAdmin.destroy');
        Route::get('order/{order}', 'OrderController@showOrder')->name('orderAdmin.show');
        Route::get('order-stocker', 'OrderController@listOrderForStocker')->name('orderStocker');
        Route::get('show-order-stocker/{order}', 'OrderController@showOrderForStocker')->name('showOrderStocker');
        Route::post('update-order-stock', 'OrderController@updateOrderStock')->name('orderUpdateStock');
        Route::post('update-payment', 'OrderController@updateStatusOrder')->name('orderUpdateStatus');
        Route::post('update-amount', 'OrderController@updatePriceOrder')->name('orderUpdatePrice');

    });
});

Route::group(['namespace' => 'Frontend'], function () {
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/404', 'HomeController@error404')->name('home');
    Route::get('/tracking-cart', 'OrderController@trackingCart')->name('trackingCart');  
    Route::get('/gio-hang', 'OrderController@cart');
    Route::get('/delete-cart', 'OrderController@deleteItemCart')->name('deleteItemCart');
    Route::post('/don-hang', 'OrderController@submitCheckout')->name('checkout');
    Route::get('/tin-tuc', 'NewsController@index');
    Route::post('/buy-now', 'HomeController@buyNow');
    Route::get('/lien-he', 'HomeController@contact');
    Route::get('/gioi-thieu', 'HomeController@aboutUs');
    Route::post('/lien-he', 'HomeController@contact');
    Route::get('/faq', 'HomeController@faq');
    Route::get('/tim-kiem', 'HomeController@search');
    Route::get('/chinh-sach-doi-tra', 'NewsController@page');
    Route::get('/chinh-sach-van-chuyen', 'NewsController@page');
    Route::get('/hinh-thuc-thanh-toan', 'NewsController@page');
    Route::get('/chinh-sach-bao-mat', 'NewsController@page');
    Route::get('/quy-dinh-su-dung', 'NewsController@page');
    Route::get('/nguyen-thi-binh', 'NewsController@page');

    Route::get('/thuong-hieu/{providerSlug}', 'HomeController@provider');
    Route::get('/tags', 'HomeController@tags')->name('tags_product');
    Route::get('/author/{slug}', 'NewsController@author');
    Route::get('/{cateSlug}', 'HomeController@category');
    Route::get('/{cateSlug}/{productnewsSlug}', 'HomeController@productDetail');
    Route::get('/preview/{cateSlug}/{productnewsSlug}', 'HomeController@previewProductDetail');
    Route::get('/preview2/{cateSlug}/{productnewsSlug}', 'HomeController@preview2ProductDetail');
    Route::post('/product/comment', 'HomeController@productComment');
    Route::post('/product/contact', 'HomeController@submitProductContact')->name('product_contact');


        /*===== đặt hàng  ===== */

    Route::post('/dat-hang', 'OrderController@addToCart')->name('addToCart');
    Route::get('/thanh-toan', 'HomeController@checkout');
/*    Route::get('/xoa-don-hang', 'OrderController@deleteItemCart')->name('deleteItemCart');
    Route::post('/gui-don-hang', 'OrderController@send')->name('send');*/
});


Route::resource('ratingNews', 'RatingNewsController');