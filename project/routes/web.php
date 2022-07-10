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
  Route::get('user/notf', function() {
    return View::make('user_notf');
  });
    Route::get('order/notf', function() {
    return View::make('order_notf');
  });
    Route::get('product/notf', function() {
    return View::make('product_notf');
  });
    Route::get('conv/notf', function() {
    return View::make('conv_notf');
  });
    Route::get('conv/notf1', function() {
    return View::make('conv_notf1');
  });

  Route::post('/json/comment','Json\JsonBlogController@comment');
  Route::post('/json/comment/edit','Json\JsonBlogController@commentedit');
  Route::get('/json/comment/delete','Json\JsonBlogController@commentdelete');

  Route::post('/json/reply','Json\JsonBlogController@reply');
  Route::post('/json/reply/edit','Json\JsonBlogController@replyedit');
  Route::get('/json/reply/delete','Json\JsonBlogController@replydelete');

  Route::post('/json/subreply','Json\JsonBlogController@subreply');
  Route::post('/json/subreply/edit','Json\JsonBlogController@subreplyedit');
  Route::get('/json/subreply/delete','Json\JsonBlogController@subreplydelete');

  Route::get('/json/order/notf','Json\JsonRequestController@order_notf');
  Route::get('/json/order/notf/clear','Json\JsonRequestController@order_notf_clear');
  Route::get('/json/product/notf','Json\JsonRequestController@product_notf');
  Route::get('/json/product/notf/clear','Json\JsonRequestController@product_notf_clear');
  Route::get('/json/user/notf','Json\JsonRequestController@user_notf');
  Route::get('/json/user/notf/clear','Json\JsonRequestController@user_notf_clear');
  Route::get('/json/conv/notf','Json\JsonRequestController@conv_notf');
  Route::get('/json/conv/notf/clear','Json\JsonRequestController@conv_notf_clear');
  Route::get('/json/conv/notf1','Json\JsonRequestController@conv_notf1');
  Route::get('/json/conv/notf/clear1','Json\JsonRequestController@conv_notf_clear1');
  Route::get('/json/compare','Json\JsonRequestController@compare');
  Route::get('/json/removecompare','Json\JsonRequestController@removecompare');
  Route::get('/json/clearcompare','Json\JsonRequestController@clearcompare');
  Route::get('/json/pos','Json\JsonRequestController@pos');
  Route::get('/json/quick','Json\JsonRequestController@quick');
  Route::get('/json/feature','Json\JsonRequestController@feature');
  Route::get('/json/gallery','Json\JsonRequestController@gallery');
  Route::post('/json/addgallery','Json\JsonRequestController@addgallery');
  Route::get('/json/removegallery','Json\JsonRequestController@delgallery');
  Route::get('/json/addbyone','Json\JsonRequestController@addbyone');
  Route::get('/json/reducebyone','Json\JsonRequestController@reducebyone');
  Route::get('/json/subcats','Json\JsonRequestController@subcats');
  Route::get('/json/childcats','Json\JsonRequestController@childcats');
  Route::get('/json/addcart','Json\JsonRequestController@addcart');
  Route::get('/json/addnumcart','Json\JsonRequestController@addnumcart');
  Route::get('/json/updatecart','Json\JsonRequestController@upcart');
  Route::get('/json/upcolor','Json\JsonRequestController@upcolor');
  Route::get('/json/removecart','Json\JsonRequestController@removecart');
  Route::get('/json/coupon','Json\JsonRequestController@coupon');
  Route::get('/json/wish','Json\JsonRequestController@wish');
  Route::get('/json/removewish','Json\JsonRequestController@removewish');
  Route::get('/json/favorite','Json\JsonRequestController@favorite');
  Route::get('/json/removefavorite','Json\JsonRequestController@removefavorite');
  Route::get('/json/suggest','Json\JsonRequestController@suggest');
  Route::get('/json/trans','Json\JsonRequestController@trans');
  Route::get('/json/transhow','Json\JsonRequestController@transhow');

  Route::get('/json/productsdata','Json\JsonRequestController@sectionProducts');

  Route::prefix('admin')->group(function() {

  Route::get('/dashboard', 'AdminController@index')->name('admin-dashboard');
  Route::get('/profile', 'AdminController@profile')->name('admin-profile');
  Route::post('/profile', 'AdminController@profileupdate')->name('admin-profile-update');
  Route::get('/reset-password', 'AdminController@passwordreset')->name('admin-password-reset');
  Route::post('/reset-password', 'AdminController@changepass')->name('admin-password-change');
  Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin-login');
  Route::post('/login', 'Auth\AdminLoginController@login')->name('admin-login-submit');
  Route::get('/logout', 'Auth\AdminLoginController@logout')->name('admin-logout');
  Route::get('/video', 'GeneralSettingController@video')->name('admin-video');
  Route::post('/video', 'GeneralSettingController@videoup')->name('admin-video-submit');
  Route::get('/large-banner', 'PageSettingController@banner')->name('admin-lbanner');
  Route::post('/large-banner', 'PageSettingController@bannerup')->name('admin-lbanner-submit');

  Route::get('/orders', 'AdminOrderController@index')->name('admin-order-index');
  Route::get('/orders/pending', 'AdminOrderController@pending')->name('admin-order-pending');
  Route::get('/orders/processing', 'AdminOrderController@processing')->name('admin-order-processing');
  Route::get('/orders/completed', 'AdminOrderController@completed')->name('admin-order-completed');
  Route::get('/orders/declined', 'AdminOrderController@declined')->name('admin-order-declined');
  Route::get('/order/{id}/show', 'AdminOrderController@show')->name('admin-order-show');
  Route::get('/order/{id}/invoice', 'AdminOrderController@invoice')->name('admin-order-invoice');
  Route::get('/order/{id}/print', 'AdminOrderController@printpage')->name('admin-order-print');
  Route::get('/order/{id1}/status/{status}', 'AdminOrderController@status')->name('admin-order-status');
  Route::post('/order/email/', 'AdminOrderController@emailsub')->name('admin-order-emailsub');
  Route::post('/order/{id}/license', 'AdminOrderController@license')->name('admin-order-license');

  Route::get('/users', 'AdminUserController@index')->name('admin-user-index');
  Route::get('/users/edit/{id}', 'AdminUserController@edit')->name('admin-user-edit');
  Route::post('/users/edit/{id}', 'AdminUserController@update')->name('admin-user-update');
  Route::get('/users/delete/{id}', 'AdminUserController@destroy')->name('admin-user-delete');
  Route::get('/user/{id}/show', 'AdminUserController@show')->name('admin-user-show');

  Route::get('/product', 'ProductController@index')->name('admin-prod-index');
  Route::get('/getproducts/','ProductController@getProducts')->name('products.getProducts');


  Route::get('/product/deactive', 'ProductController@deactive')->name('admin-prod-deactive');
  Route::get('/product/create', 'ProductController@create')->name('admin-prod-create');
  Route::post('/product/create', 'ProductController@store')->name('admin-prod-store');
  Route::post('/product/create1', 'ProductController@store1')->name('admin-prod-store1');
  Route::post('/product/create2', 'ProductController@store2')->name('admin-prod-store2');
  Route::get('/product/edit/{id}', 'ProductController@edit')->name('admin-prod-edit');
  Route::post('/product/update/{id}', 'ProductController@update')->name('admin-prod-update');
  Route::post('/product/update1/{id}', 'ProductController@update1')->name('admin-prod-update1');
  Route::post('/product/update2/{id}', 'ProductController@update2')->name('admin-prod-update2');
  Route::post('/product/feature/{id}', 'ProductController@feature')->name('admin-prod-feature');
  Route::get('/product/delete/{id}', 'ProductController@destroy')->name('admin-prod-delete');
  Route::get('/product/status/{id1}/{id2}', 'ProductController@status')->name('admin-prod-st');

  Route::get('/stores', 'AdminController@StoreList')->name('admin-stores');
  Route::get('/store/create', 'AdminController@createStore')->name('admin-store-create');
  Route::post('/store/create', 'AdminController@storeSave')->name('admin-store-store');
  Route::get('/store/edit/{id}', 'AdminController@editStore')->name('admin-store-edit');
  Route::post('/store/update/{id}', 'AdminController@updateStore')->name('admin-store-update');

    Route::post('/store/change', 'AdminController@storeChange')->name('admin-store-change');

  Route::get('/import/create', 'ImportController@create')->name('admin-import-create');
  Route::post('/import/create', 'ImportController@store')->name('admin-import-store');

  Route::get('/product/admin-verify/{id1}/{id2}', 'ProductController@AdminVerify')->name('admin-prod-app-st');

  Route::get('/category', 'CategoryController@index')->name('admin-cat-index');
  Route::get('/category/create', 'CategoryController@create')->name('admin-cat-create');
  Route::post('/category/create', 'CategoryController@store')->name('admin-cat-store');
  Route::get('/category/edit/{id}', 'CategoryController@edit')->name('admin-cat-edit');
  Route::post('/category/update/{id}', 'CategoryController@update')->name('admin-cat-update');
  Route::get('/category/delete/{id}', 'CategoryController@destroy')->name('admin-cat-delete');
  Route::get('/category/status/{id1}/{id2}', 'CategoryController@status')->name('admin-cat-st');

  Route::get('/subcategory', 'SubcategoryController@index')->name('admin-subcat-index');
  Route::get('/subcategory/create', 'SubcategoryController@create')->name('admin-subcat-create');
  Route::post('/subcategory/create', 'SubcategoryController@store')->name('admin-subcat-store');
  Route::get('/subcategory/edit/{id}', 'SubcategoryController@edit')->name('admin-subcat-edit');
  Route::post('/subcategory/update/{id}', 'SubcategoryController@update')->name('admin-subcat-update');
  Route::get('/subcategory/delete/{id}', 'SubcategoryController@destroy')->name('admin-subcat-delete');
  Route::get('/subcategory/status/{id1}/{id2}', 'SubcategoryController@status')->name('admin-subcat-st');

  Route::get('/childcategory', 'ChildcategoryController@index')->name('admin-childcat-index');
  Route::get('/childcategory/create', 'ChildcategoryController@create')->name('admin-childcat-create');
  Route::post('/childcategory/create', 'ChildcategoryController@store')->name('admin-childcat-store');
  Route::get('/childcategory/edit/{id}', 'ChildcategoryController@edit')->name('admin-childcat-edit');
  Route::post('/childcategory/update/{id}', 'ChildcategoryController@update')->name('admin-childcat-update');
  Route::get('/childcategory/delete/{id}', 'ChildcategoryController@destroy')->name('admin-childcat-delete');
  Route::get('/childcategory/status/{id1}/{id2}', 'ChildcategoryController@status')->name('admin-childcat-st');

  Route::get('/coupon', 'AdminCouponController@index')->name('admin-cp-index');
  Route::get('/coupon/create', 'AdminCouponController@create')->name('admin-cp-create');
  Route::post('/coupon/create', 'AdminCouponController@store')->name('admin-cp-store');
  Route::get('/coupon/edit/{id}', 'AdminCouponController@edit')->name('admin-cp-edit');
  Route::post('/coupon/edit/{id}', 'AdminCouponController@update')->name('admin-cp-update');
  Route::get('/coupon/delete/{id}', 'AdminCouponController@destroy')->name('admin-cp-delete');
  Route::get('/coupon/status/{id1}/{id2}', 'AdminCouponController@status')->name('admin-cp-st');

  Route::get('/blog', 'AdminBlogController@index')->name('admin-blog-index');
  Route::get('/blog/create', 'AdminBlogController@create')->name('admin-blog-create');
  Route::post('/blog/create', 'AdminBlogController@store')->name('admin-blog-store');
  Route::get('/blog/edit/{id}', 'AdminBlogController@edit')->name('admin-blog-edit');
  Route::post('/blog/edit/{id}', 'AdminBlogController@update')->name('admin-blog-update');
  Route::get('/blog/delete/{id}', 'AdminBlogController@destroy')->name('admin-blog-delete');

  Route::get('/subscription', 'SubscriptionController@index')->name('admin-subscription-index');
  Route::get('/subscription/create', 'SubscriptionController@create')->name('admin-subscription-create');
  Route::post('/subscription/create', 'SubscriptionController@store')->name('admin-subscription-store');
  Route::get('/subscription/edit/{id}', 'SubscriptionController@edit')->name('admin-subscription-edit');
  Route::post('/subscription/edit/{id}', 'SubscriptionController@update')->name('admin-subscription-update');
  Route::get('/subscription/delete/{id}', 'SubscriptionController@destroy')->name('admin-subscription-delete');

  Route::get('/bottom-banners', 'ImageController@index')->name('admin-img1-index');
  Route::get('/bottom-banner/create', 'ImageController@create')->name('admin-img1-create');
  Route::post('/bottom-banner/create', 'ImageController@store')->name('admin-img1-store');
  Route::get('/bottom-banner/edit/{id}', 'ImageController@edit')->name('admin-img1-edit');
  Route::post('/bottom-banner/edit/{id}', 'ImageController@update')->name('admin-img1-update');
  Route::get('/bottom-banner/delete/{id}', 'ImageController@destroy')->name('admin-img1-delete');

  Route::get('/banner/top', 'BannerController@top')->name('admin-banner-top');
  Route::post('/banner/top', 'BannerController@topup')->name('admin-banner-topup');
  Route::get('/banner/bottom', 'BannerController@bottom')->name('admin-banner-bottom');
  Route::post('/banner/bottom', 'BannerController@bottomup')->name('admin-banner-bottomup');
    Route::get('/general-settings/countdown', 'GeneralSettingController@countdown')->name('admin-gs-countdown');
  Route::post('/general-settings/countdown', 'GeneralSettingController@countdownup')->name('admin-gs-countdownup');

  Route::group(['middleware'=>'admininistrator'],function(){

  Route::get('/vendors', 'AdminVendorController@index')->name('admin-vendor-index');
  Route::get('/vendors/subs', 'AdminVendorController@subs')->name('admin-vendor-subs');
  Route::get('/vendors/sub/{id}', 'AdminVendorController@sub')->name('admin-vendor-sub');
  Route::get('/vendors/{id}/show', 'AdminVendorController@show')->name('admin-vendor-show');
  Route::get('/vendor/edit/{id}', 'AdminVendorController@edit')->name('admin-vendor-edit');
  Route::post('/vendor/edit/{id}', 'AdminVendorController@update')->name('admin-vendor-update');
  Route::get('/vendors', 'AdminVendorController@index')->name('admin-vendor-index');
  Route::get('/vendors/pending', 'AdminVendorController@pending')->name('admin-vendor-pending');
  Route::get('/vendors/status/{id1}/{id2}', 'AdminVendorController@status')->name('admin-vendor-st');
  Route::get('/vendors/delete/{id}', 'AdminVendorController@destroy')->name('admin-vendor-delete');
  Route::get('/vendors/email/{id}', 'AdminVendorController@email')->name('admin-vendor-email');
  Route::get('/vendors/withdraws', 'AdminVendorController@withdraws')->name('admin-vendor-wt');
  Route::get('/vendors/withdraws/pending', 'AdminVendorController@pendings')->name('admin-wt-pending');
  Route::get('/vendors/withdraw/details/{id}', 'AdminVendorController@withdrawdetails')->name('admin-vendor-wtd');
  Route::get('/vendors/withdraw/accept/{id}', 'AdminVendorController@accept')->name('admin-wt-accept');
  Route::get('/vendors/withdraw/reject/{id}', 'AdminVendorController@reject')->name('admin-wt-reject');
  Route::get('/users/withdraws', 'AdminVendorController@userwithdraws')->name('admin-vendor-wtt');
  Route::get('/users/withdraws/pending', 'AdminVendorController@userpendings')->name('admin-wtt-pending');
  Route::get('/users/withdraw/details/{id}', 'AdminVendorController@userwithdrawdetails')->name('admin-vendor-wttd');
  Route::get('/users/withdraw/accept/{id}', 'AdminVendorController@useraccept')->name('admin-wtt-accept');
  Route::get('/users/withdraw/reject/{id}', 'AdminVendorController@userreject')->name('admin-wtt-reject');


  Route::get('/faq', 'FaqController@index')->name('admin-fq-index');
  Route::get('/faq/create', 'FaqController@create')->name('admin-fq-create');
  Route::post('/faq/create', 'FaqController@store')->name('admin-fq-store');
  Route::get('/faq/edit/{id}', 'FaqController@edit')->name('admin-fq-edit');
  Route::post('/faq/update/{id}', 'FaqController@update')->name('admin-fq-update');

  Route::get('/faq/delete/{id}', 'FaqController@destroy')->name('admin-fq-delete');


  Route::get('/currency', 'AdminCurrencyController@index')->name('admin-currency-index');
  Route::get('/currency/create', 'AdminCurrencyController@create')->name('admin-currency-create');
  Route::post('/currency/create', 'AdminCurrencyController@store')->name('admin-currency-store');
  Route::get('/currency/edit/{id}', 'AdminCurrencyController@edit')->name('admin-currency-edit');
  Route::post('/currency/update/{id}', 'AdminCurrencyController@update')->name('admin-currency-update');
  Route::get('/currency/delete/{id}', 'AdminCurrencyController@destroy')->name('admin-currency-delete');
  Route::get('/currency/status/{id1}/{id2}', 'AdminCurrencyController@status')->name('admin-currency-st');

  Route::get('/page', 'PageController@index')->name('admin-page-index');
  Route::get('/page/create', 'PageController@create')->name('admin-page-create');
  Route::post('/page/create', 'PageController@store')->name('admin-page-store');
  Route::get('/page/edit/{id}', 'PageController@edit')->name('admin-page-edit');
  Route::post('/page/update/{id}', 'PageController@update')->name('admin-page-update');
  Route::get('/page/delete/{id}', 'PageController@destroy')->name('admin-page-delete');


  Route::get('/paymentgateway', 'PaymentGatewayController@index')->name('admin-payment-index');
  Route::get('/paymentgateway/create', 'PaymentGatewayController@create')->name('admin-payment-create');
  Route::post('/paymentgateway/create', 'PaymentGatewayController@store')->name('admin-payment-store');
  Route::get('/paymentgateway/edit/{id}', 'PaymentGatewayController@edit')->name('admin-payment-edit');
  Route::post('/paymentgateway/update/{id}', 'PaymentGatewayController@update')->name('admin-payment-update');
  Route::get('/paymentgateway/delete/{id}', 'PaymentGatewayController@destroy')->name('admin-payment-delete');
  Route::get('/paymentgateway/st/{id1}/{id2}', 'PaymentGatewayController@status')->name('admin-payment-st');

  Route::get('/testimonial', 'PortfolioController@index')->name('admin-ad-index');
  Route::get('/testimonial/create', 'PortfolioController@create')->name('admin-ad-create');
  Route::post('/testimonial/create', 'PortfolioController@store')->name('admin-ad-store');
  Route::get('/testimonial/edit/{id}', 'PortfolioController@edit')->name('admin-ad-edit');
  Route::post('/testimonial/edit/{id}', 'PortfolioController@update')->name('admin-ad-update');
  Route::get('/testimonial/delete/{id}', 'PortfolioController@destroy')->name('admin-ad-delete');

  Route::get('/services', 'AdminServiceController@index')->name('admin-service-index');
  Route::get('/services/create', 'AdminServiceController@create')->name('admin-service-create');
  Route::post('/services/create', 'AdminServiceController@store')->name('admin-service-store');
  Route::get('/services/edit/{id}', 'AdminServiceController@edit')->name('admin-service-edit');
  Route::post('/services/edit/{id}', 'AdminServiceController@update')->name('admin-service-update');
  Route::get('/services/delete/{id}', 'AdminServiceController@destroy')->name('admin-service-delete');

  Route::get('/slider', 'SliderController@index')->name('admin-sl-index');
  Route::get('/slider/create', 'SliderController@create')->name('admin-sl-create');
  Route::post('/slider/create', 'SliderController@store')->name('admin-sl-store');
  Route::get('/slider/edit/{id}', 'SliderController@edit')->name('admin-sl-edit');
  Route::post('/slider/edit/{id}', 'SliderController@update')->name('admin-sl-update');
  Route::get('/slider/delete/{id}', 'SliderController@destroy')->name('admin-sl-delete');

  Route::get('/brand', 'BrandController@index')->name('admin-img-index');
  Route::get('/brand/create', 'BrandController@create')->name('admin-img-create');
  Route::post('/brand/create', 'BrandController@store')->name('admin-img-store');
  Route::get('/brand/edit/{id}', 'BrandController@edit')->name('admin-img-edit');
  Route::post('/brand/edit/{id}', 'BrandController@update')->name('admin-img-update');
  Route::get('/brand/delete/{id}', 'BrandController@destroy')->name('admin-img-delete');

  Route::get('/series', 'SeriesController@index')->name('admin-series-index');
  Route::get('/series/create', 'SeriesController@create')->name('admin-series-create');
  Route::post('/series/create', 'SeriesController@store')->name('admin-series-store');
  Route::get('/series/edit/{id}', 'SeriesController@edit')->name('admin-series-edit');
  Route::post('/series/edit/{id}', 'SeriesController@update')->name('admin-series-update');
  Route::get('/series/delete/{id}', 'SeriesController@destroy')->name('admin-series-delete');

  Route::get('/shipping', 'ShippingController@index')->name('admin-shipping-index');
  Route::get('/shipping/create', 'ShippingController@create')->name('admin-shipping-create');
  Route::post('/shipping/create', 'ShippingController@store')->name('admin-shipping-store');
  Route::get('/shipping/edit/{id}', 'ShippingController@edit')->name('admin-shipping-edit');
  Route::post('/shipping/edit/{id}', 'ShippingController@update')->name('admin-shipping-update');
  Route::get('/shipping/delete/{id}', 'ShippingController@destroy')->name('admin-shipping-delete');

  Route::get('/pickup', 'PickupController@index')->name('admin-pick-index');
  Route::get('/pickup/create', 'PickupController@create')->name('admin-pick-create');
  Route::post('/pickup/create', 'PickupController@store')->name('admin-pick-store');
  Route::get('/pickup/edit/{id}', 'PickupController@edit')->name('admin-pick-edit');
  Route::post('/pickup/edit/{id}', 'PickupController@update')->name('admin-pick-update');
  Route::get('/pickup/delete/{id}', 'PickupController@destroy')->name('admin-pick-delete');

  Route::get('/page-settings/contact', 'PageSettingController@contact')->name('admin-ps-contact');
  Route::post('/page-settings/contact', 'PageSettingController@contactupdate')->name('admin-ps-contact-submit');

  Route::get('/staff', 'AdminStaffController@index')->name('admin-staff-index');
  Route::get('/staff/create', 'AdminStaffController@create')->name('admin-staff-create');
  Route::post('/staff/create', 'AdminStaffController@store')->name('admin-staff-store');
  Route::get('/staff/edit/{id}', 'AdminStaffController@show')->name('admin-staff-show');
  Route::get('/staff/delete/{id}', 'AdminStaffController@destroy')->name('admin-staff-delete');

  Route::get('/social', 'SocialSettingController@index')->name('admin-social-index');
  Route::post('/social/update', 'SocialSettingController@update')->name('admin-social-update');
  Route::get('/social/facebook', 'SocialSettingController@facebook')->name('admin-social-facebook');
  Route::post('/social/facebook', 'SocialSettingController@facebookupdate')->name('admin-social-ufacebook');
  Route::get('/social/google', 'SocialSettingController@google')->name('admin-social-google');
  Route::post('/social/google', 'SocialSettingController@googleupdate')->name('admin-social-ugoogle');
  Route::get('/seotools/analytics', 'SeoToolController@analytics')->name('admin-seotool-analytics');
  Route::post('/seotools/analytics/update', 'SeoToolController@analyticsupdate')->name('admin-seotool-analytics-update');
  Route::get('/seotools/keywords', 'SeoToolController@keywords')->name('admin-seotool-keywords');
  Route::post('/seotools/keywords/update', 'SeoToolController@keywordsupdate')->name('admin-seotool-keywords-update');

  Route::get('/general-settings/logo', 'GeneralSettingController@logo')->name('admin-gs-logo');
  Route::post('/general-settings/logo', 'GeneralSettingController@logoup')->name('admin-gs-logoup');

  Route::get('/general-settings/affilate', 'GeneralSettingController@affilate')->name('admin-gs-affilate');
  Route::post('/general-settings/affilate', 'GeneralSettingController@affilateup')->name('admin-gs-affilateup');

  Route::get('/general-settings/popup', 'GeneralSettingController@popup')->name('admin-gs-popup');
  Route::post('/general-settings/popup', 'GeneralSettingController@popupup')->name('admin-gs-popupup');

  Route::get('/general-settings/favicon', 'GeneralSettingController@fav')->name('admin-gs-fav');
  Route::post('/general-settings/favicon', 'GeneralSettingController@favup')->name('admin-gs-favup');

  Route::get('/general-settings/payments', 'GeneralSettingController@payments')->name('admin-gs-payments');
  Route::post('/general-settings/payments', 'GeneralSettingController@paymentsup')->name('admin-gs-paymentsup');
  Route::get('/general-settings/guest/{status}', 'GeneralSettingController@guest')->name('admin-gs-guest');
  Route::get('/general-settings/paypal/{status}', 'GeneralSettingController@paypal')->name('admin-gs-paypal');
  Route::get('/general-settings/stripe/{status}', 'GeneralSettingController@stripe')->name('admin-gs-stripe');
   Route::get('/general-settings/razorpay/{status}', 'GeneralSettingController@razorpay')->name('admin-gs-razorpay');
 Route::get('/general-settings/razorpaysandboxcheck/{status}', 'GeneralSettingController@razorpaysandboxcheck')->name('admin-gs-razorpaysandboxcheck');
  Route::get('/general-settings/cod/{status}', 'GeneralSettingController@cod')->name('admin-gs-cod');
  Route::get('/issubscribe/{status}', 'GeneralSettingController@issubscribe')->name('admin-gs-issubscribe');

  Route::get('/general-settings/contents', 'GeneralSettingController@contents')->name('admin-gs-contents');
  Route::post('/general-settings/contents', 'GeneralSettingController@contentsup')->name('admin-gs-contentsup');

  Route::get('/general-settings/bgimg', 'GeneralSettingController@bgimg')->name('admin-gs-bgimg');
  Route::post('/general-settings/bgimgup', 'GeneralSettingController@bgimgup')->name('admin-gs-bgimgup');

  Route::get('/general-settings/cimg', 'GeneralSettingController@cimg')->name('admin-gs-cimg');
  Route::post('/general-settings/cimgup', 'GeneralSettingController@cimgup')->name('admin-gs-cimgup');

  Route::get('/general-settings/copyright', 'GeneralSettingController@about')->name('admin-gs-about');
  Route::post('/general-settings/copyright', 'GeneralSettingController@aboutup')->name('admin-gs-aboutup');

  Route::get('/general-settings/home-info', 'GeneralSettingController@bginfo')->name('admin-gs-bginfo');
  Route::post('/general-settings/home-info', 'GeneralSettingController@bginfoup')->name('admin-gs-bginfoup');

  Route::get('/general-settings/feature', 'GeneralSettingController@feature')->name('admin-gs-feature');
  Route::post('/general-settings/feature', 'GeneralSettingController@featureup')->name('admin-gs-featureup');

  Route::get('/general-settings/success', 'GeneralSettingController@successm')->name('admin-gs-successm');
  Route::post('/general-settings/success', 'GeneralSettingController@successmup')->name('admin-gs-successmup');

  Route::get('/subscribers', 'SubscriberController@index')->name('admin-subs-index');
  Route::get('/subscribers/download', 'SubscriberController@download')->name('admin-subs-download');

  Route::get('/languages', 'LanguageController@index')->name('admin-lang-index');
  Route::get('/languages/create', 'LanguageController@create')->name('admin-lang-create');
  Route::get('/languages/edit/{id}', 'LanguageController@edit')->name('admin-lang-edit');
  Route::post('/languages/create', 'LanguageController@store')->name('admin-lang-store');
  Route::post('/languages/edit/{id}', 'LanguageController@update')->name('admin-lang-update');
  Route::get('/languages/delete/{id}', 'LanguageController@destroy')->name('admin-lang-delete');
  Route::get('/languages/status/{id1}/{id2}', 'LanguageController@status')->name('admin-lang-st');
  Route::get('/regvendor/{status}', 'GeneralSettingController@regvendor')->name('admin-gs-regvendor');
  Route::get('/rtl/{status}', 'GeneralSettingController@rtl')->name('admin-gs-rtl');
  Route::get('/vendor/registration', 'GeneralSettingController@reg')->name('admin-gs-reg');

  Route::get('/general-settings/loader', 'GeneralSettingController@load')->name('admin-gs-load');
  Route::post('/general-settings/loader', 'GeneralSettingController@loadup')->name('admin-gs-loadup');
  //new
  Route::get('/products/popular/{id}','SeoToolController@popular')->name('admin-prod-popular');

  Route::get('/reviews', 'AdminController@reviews')->name('admin-review-index');
  Route::get('/review/delete/{id}', 'AdminController@reviewdelete')->name('admin-review-delete');
  Route::get('/review/show/{id}', 'AdminController@reviewshow')->name('admin-review-show');

  Route::get('/comments', 'AdminController@comments')->name('admin-comment-index');
  Route::get('/comments/delete/{id}', 'AdminController@commentdelete')->name('admin-comment-delete');
  Route::get('/comments/show/{id}', 'AdminController@commentshow')->name('admin-comment-show');

  Route::get('/messages', 'AdminController@messages')->name('admin-message-index');
  Route::get('/message/{id}', 'AdminController@message')->name('admin-message-show');
  Route::post('/message/post', 'AdminController@postmessage')->name('admin-message-store');
  Route::get('/message/{id}/delete', 'AdminController@messagedelete')->name('admin-message-delete');
  Route::post('/user/send/message', 'AdminController@usercontact')->name('admin-send-message');

  Route::get('/email-templates', 'EmailController@index')->name('admin-mail-index');
  Route::get('/email-templates/{id}', 'EmailController@edit')->name('admin-mail-edit');
  Route::post('/email-templates/{id}', 'EmailController@update')->name('admin-mail-update');
  Route::get('/email-config', 'EmailController@config')->name('admin-mail-config');
  Route::Post('/email-config', 'EmailController@configupdate')->name('admin-mail-configupdate');
  Route::get('/groupemail', 'EmailController@groupemail')->name('admin-group-show');
  Route::post('/groupemailpost', 'EmailController@groupemailpost')->name('admin-group-submit');
  Route::get('/comment/{status}', 'GeneralSettingController@comment')->name('admin-gs-comment');
  Route::get('/affilate/{status}', 'GeneralSettingController@isaffilate')->name('admin-gs-isaffilate');
  Route::get('/faqup/{status}', 'PageSettingController@faqupdate')->name('admin-faq-update');
  Route::get('/contact/{status}', 'PageSettingController@contactup')->name('admin-ps-contactup');
  Route::get('/issmtp/{status}', 'GeneralSettingController@issmtp')->name('admin-gs-issmtp');
  Route::get('/talkto/{status}', 'GeneralSettingController@talkto')->name('admin-gs-talkto');
  Route::get('/loader/{status}', 'GeneralSettingController@isloader')->name('admin-gs-isloader');
  Route::get('/currencyup/{status}', 'PageSettingController@currencyup')->name('admin-cur-update');
  Route::get('/langup/{status}', 'GeneralSettingController@lungup')->name('admin-lung-update');
  Route::get('/facebook/{status}', 'SocialSettingController@facebookup')->name('admin-social-facebookup');
  Route::get('/google/{status}', 'SocialSettingController@googleup')->name('admin-social-googleup');
  Route::get('/loader/{status}', 'GeneralSettingController@isloader')->name('admin-gs-isloader');


    });
  });


  Route::prefix('user')->group(function() {
  Route::get('/dashboard', 'UserController@index')->name('user-dashboard');
  Route::get('/package', 'UserController@package')->name('user-package');
  Route::get('/wishlist', 'UserController@wishlists')->name('user-wishlist');
  Route::get('/wishlists', 'UserController@wishlist')->name('user-wishlists');
  Route::get('/favorites', 'UserController@favorites')->name('user-favorites');
  Route::get('/wishlists/{sort}', 'UserController@wishlistsort')->name('user-wishlistsort');
  Route::get('/wishlist/product/{id}/delete', 'UserController@delete')->name('user-wish-delete');
  Route::get('/favorite/vendor/{id}/delete', 'UserController@favdelete')->name('user-favorite-delete');
  Route::get('/reset', 'UserController@resetform')->name('user-reset');
  Route::post('/reset', 'UserController@reset')->name('user-reset-submit');
  Route::get('/profile', 'UserController@profile')->name('user-profile');
  Route::post('/profile', 'UserController@profileupdate')->name('user-profile-update');

    Route::get('/password-reset', 'UserController@resetform')->name('customer-reset');
  Route::post('/password-reset', 'UserController@Customerreset')->name('customer-reset-submit');


  Route::get('/my-profile', 'UserController@profile')->name('customer-profile');
  Route::post('/my-profile', 'UserController@Customerprofileupdate')->name('customer-profile-update');

Route::get('/my-orders', 'UserController@orders')->name('customer-orders');
Route::get('/my-order/{id}', 'UserController@order')->name('customer-order');
Route::get('/my-order/{slug}/{id}', 'UserController@orderdownload')->name('user-order-download');
Route::get('print/my-order/print/{id}', 'UserController@orderprint')->name('user-order-print');

  Route::get('/forgot', 'Auth\UserForgotController@showforgotform')->name('user-forgot');
  Route::post('/forgot', 'Auth\UserForgotController@forgot')->name('user-forgot-submit');
  Route::get('/login', 'Auth\UserLoginController@showLoginForm')->name('user-login');
  Route::post('/login', 'Auth\UserLoginController@login')->name('user-login-submit');
  Route::get('/loginajax', 'Auth\UserLoginController@loginAjax')->name('user-login-ajax-submit');
  Route::get('/register', 'Auth\UserRegisterController@showRegisterForm')->name('user-register');
  Route::post('/register', 'Auth\UserRegisterController@register')->name('user-register-submit');
  Route::get('/registerajax', 'Auth\UserRegisterController@RegisterAjax')->name('user-signup-ajax-submit');
  Route::get('/logout', 'Auth\UserLoginController@logout')->name('user-logout');
  Route::post('/user/contact', 'UserController@usercontact');
  Route::get('/orders', 'UserController@orders')->name('user-orders');
  Route::get('/order/{id}', 'UserController@order')->name('user-order');
  Route::get('/order/{slug}/{id}', 'UserController@orderdownload')->name('user-order-download');
  Route::get('print/order/print/{id}', 'UserController@orderprint')->name('user-order-print');

  Route::get('/messages', 'UserController@messages')->name('user-messages');
  Route::get('/message/{id}', 'UserController@message')->name('user-message');
  Route::post('/message/post', 'UserController@postmessage')->name('user-message-post');
  Route::get('/message/{id}/delete', 'UserController@messagedelete')->name('user-message-delete');
  //new
  Route::get('admin/messages', 'UserController@adminmessages')->name('user-message-index');
  Route::get('admin/message/{id}', 'UserController@adminmessage')->name('user-message-show');
  Route::post('admin/message/post', 'UserController@adminpostmessage')->name('user-message-store');
  Route::get('admin/message/{id}/delete', 'UserController@adminmessagedelete')->name('user-message-delete1');
  Route::post('admin/user/send/message', 'UserController@adminusercontact')->name('user-send-message');

  Route::post('/paypal/submit', 'SubscribePaypalController@store')->name('user.paypal.submit');
  Route::get('/paypal/cancle', 'SubscribePaypalController@paycancle')->name('user.payment.cancle');
  Route::get('/paypal/return', 'SubscribePaypalController@payreturn')->name('user.payment.return');
  Route::post('/paypal/notify', 'SubscribePaypalController@notify')->name('user.payment.notify');
  Route::post('/stripe/submit', 'SubscribeStripeController@store')->name('user.stripe.submit');
  Route::prefix('vendor')->group(function() {

  Route::get('/subscription/{id}', 'UserController@vendorrequest')->name('user-vendor-request');
  Route::post('/vendor-request', 'UserController@vendorrequestsub')->name('user-vendor-request-submit');

  Route::get('/affilate/code', 'UserController@affilate_code')->name('user-affilate-code');

  Route::get('/affilate/withdraw', 'UserWithdrawController@index')->name('user-wwt-index');
  Route::get('/affilate/withdraw/create', 'UserWithdrawController@create')->name('user-wwt-create');
  Route::post('/affilate/withdraw/create', 'UserWithdrawController@store')->name('user-wwt-store');

  Route::group(['middleware'=>'vendor'],function(){

  Route::get('/product', 'UserProductController@index')->name('user-prod-index');
  Route::get('/product/create', 'UserProductController@create')->name('user-prod-create');
Route::post('/product/create', 'UserProductController@store')->name('user-prod-store');
Route::post('/product/create1', 'UserProductController@store1')->name('user-prod-store1');
Route::post('/product/create2', 'UserProductController@store2')->name('user-prod-store2');
  Route::get('/product/edit/{id}', 'UserProductController@edit')->name('user-prod-edit');
  Route::post('/product/update/{id}', 'UserProductController@update')->name('user-prod-update');
  Route::post('/product/update1/{id}', 'UserProductController@update1')->name('user-prod-update1');
  Route::post('/product/update2/{id}', 'UserProductController@update2')->name('user-prod-update2');
  Route::get('/product/delete/{id}', 'UserProductController@destroy')->name('user-prod-delete');
  Route::get('/product/status/{id1}/{id2}', 'UserProductController@status')->name('user-prod-st');

  Route::get('/slider', 'VendorSliderController@index')->name('user-sl-index');
  Route::get('/slider/create', 'VendorSliderController@create')->name('user-sl-create');
  Route::post('/slider/create', 'VendorSliderController@store')->name('user-sl-store');
  Route::get('/slider/edit/{id}', 'VendorSliderController@edit')->name('user-sl-edit');
  Route::post('/slider/edit/{id}', 'VendorSliderController@update')->name('user-sl-update');
  Route::get('/slider/delete/{id}', 'VendorSliderController@destroy')->name('user-sl-delete');

  Route::get('/shop/', 'UserController@shop')->name('user-shop-desc');
  Route::post('/shop/', 'UserController@shopup')->name('user-shop-descup');

  Route::get('/social', 'UserController@social')->name('user-social-index');
  Route::post('/social/update', 'UserController@socialupdate')->name('user-social-update');


  Route::get('/orders', 'UserController@vendororders')->name('vendor-order-index');
  Route::get('/order/{slug}/show', 'UserController@vendororder')->name('vendor-order-show');
  Route::get('/order/{slug}/invoice', 'UserController@invoice')->name('vendor-order-invoice');
  Route::get('/order/{slug}/print', 'UserController@printpage')->name('vendor-order-print');
  Route::get('/order/{slug}/status/{status}', 'UserController@status')->name('vendor-order-status');
  Route::get('/order/email/{email}', 'UserController@email')->name('vendor-order-email');
  Route::post('/order/email/', 'UserController@emailsub')->name('vendor-order-emailsub');
  Route::post('/order/{slug}/license/', 'UserController@vendorlicense')->name('vendor-order-license');

  Route::get('/shipping-cost/', 'UserController@ship')->name('user-shop-ship');
  Route::post('/shipping-cost/', 'UserController@shipup')->name('user-shop-shipup');

  Route::get('/withdraw', 'VendorWithdrawController@index')->name('user-wt-index');
  Route::get('/withdraw/create', 'VendorWithdrawController@create')->name('user-wt-create');
  Route::post('/withdraw/create', 'VendorWithdrawController@store')->name('user-wt-store');

  });

  });


  Route::post('/payment', 'PaymentController@store')->name('payment.submit');
  Route::get('/payment/cancle', 'PaymentController@paycancle')->name('payment.cancle');
  Route::get('/payment/return', 'PaymentController@payreturn')->name('payment.return');

  });


  Route::get('admin/check/movescript', 'AdminController@movescript')->name('admin-move-script');
  Route::get('admin/generate/backup', 'AdminController@generate_bkup')->name('admin-generate-backup');
  Route::get('admin/activation', 'AdminController@activation')->name('admin-activation-form');
  Route::post('admin/activation', 'AdminController@activation_submit')->name('admin-activate-purchase');
  Route::get('admin/clear/backup', 'AdminController@clear_bkup')->name('admin-clear-backup');

  Route::post('the/genius/ocean/2441139', 'FrontendController@subscription');
  Route::get('finalize', 'FrontendController@finalize');

  Route::get('/','FrontendController@index')->name('front.index');
  Route::get('/extra','FrontendController@extraIndex')->name('front.extraIndex');
  Route::get('/lang/{id}','FrontendController@lang')->name('front.lang');
  Route::get('/currency/{id}','FrontendController@currency')->name('front.curr');
  Route::get('/faq.html','FrontendController@faq')->name('front.faq');
  Route::get('/contact.html','FrontendController@contact')->name('front.contact');


  Route::get('/{slug1}/{slug2}.html','FrontendController@subcategory')->name('front.subcategory');

  Route::get('/sidebarsearch/findseries','FrontendController@FindBrandSeries');
  Route::get('/sidebarsearch/findcategories','FrontendController@FindBrandCategories');
  Route::get('/sidebarsearch/findsubcategories','FrontendController@FindSubCategories');


  //Route::get('/product/{id}/{slug}','FrontendController@product')->name('front.product');

  Route::post('/product/review','FrontendController@reviewsubmit')->name('front.review.submit');
  Route::get('/cart','FrontendController@cart')->name('front.cart');
  Route::get('/compare','FrontendController@compare')->name('front.compare');

  //Route::get('/checkout','FrontendController@checkout')->name('front.checkout');

  // CHECKOUT SECTION
 Route::get('/checkout/','Front\CheckoutController@checkout')->name('front.checkout');
 Route::get('/checkout/payment/{slug1}/{slug2}','Front\CheckoutController@loadpayment')->name('front.load.payment');
 Route::get('/checkout/payment/return', 'Front\PaymentController@payreturn')->name('payment.return');
 Route::get('/checkout/payment/cancle', 'Front\PaymentController@paycancle')->name('payment.cancle');
 Route::post('/checkout/payment/notify', 'Front\PaymentController@notify')->name('payment.notify');
 Route::post('/paypal-submit', 'Front\PaymentController@store')->name('paypal.submit');

 Route::post('/payu-process', 'Front\PaymentController@processPayuPayment')->name('payu.submit');
 Route::get('/payu-cancel', 'Front\PaymentController@payuSubscribeCancel')->name('payu.cancel');
 Route::post('/payu-response', 'Front\PaymentController@payuResponse')->name('payu.response');

 Route::post('/gateway', 'Front\CheckoutController@gateway')->name('gateway.submit');
   Route::get('/ajax-get-states','Front\CheckoutController@getStates');

  Route::get('/tags/{tag}','FrontendController@tags')->name('front.tags');
  Route::get('/search','FrontendController@search')->name('front.search');
  Route::get('/search/{search}','FrontendController@searchs')->name('front.searchs');
  Route::get('/search/{search}/{sort}','FrontendController@searchss')->name('front.searchss');
  //Route::get('/blog','FrontendController@blog')->name('front.blog');
  //Route::get('/blog/{id}','FrontendController@blogshow')->name('front.blogshow');
  Route::post('/contact','FrontendController@contactemail')->name('front.contact.submit');
  Route::post('/subscribe','FrontendController@subscribe')->name('front.subscribe.submit');

  Route::post('/inquire-product','FrontendController@InquirySend')->name('inquire-product');

  Route::post('/advance-search', 'FrontendController@AdvanceSearch')->name('advance-search-form');

  Route::post('/payment', 'PaymentController@store')->name('payment.submit');
  Route::get('/payment/cancle', 'PaymentController@paycancle')->name('payment.cancle');
  Route::get('/payment/return', 'PaymentController@payreturn')->name('payment.return');
  Route::post('/payment/notify', 'PaymentController@notify')->name('payment.notify');

  Route::post('/stripe-submit', 'StripeController@store')->name('stripe.submit');
  Route::post('/razorpay-submit', 'RazorpayController@store')->name('razorpay.submit');
  Route::post('/razorpay-verifypayment', 'RazorpayController@VerifyPayment')->name('razorpay.verifypayment');
  Route::post('/cashondelivery', 'FrontendController@cashondelivery')->name('cash.submit');
  Route::post('/mobile_money', 'FrontendController@mobilemoney')->name('mobile.submit');
  Route::post('/bank_wire', 'FrontendController@bankwire')->name('bank.submit');
  Route::post('/gateway', 'FrontendController@gateway')->name('gateway.submit');
  Route::get('/contact/refresh_code','FrontendController@refresh_code');
//  Route::post('/vendor/registration', 'FrontendController@vendor_register')->name('vendor.registration');

  Route::get('auth/{provider}', 'Auth\SocialRegisterController@redirectToProvider')->name('social-provider');
  Route::get('auth/{provider}/callback', 'Auth\SocialRegisterController@handleProviderCallback');


  Route::get('/{slug}.html','FrontendController@page')->name('front.page'); //


Route::get('updateproductcat','FrontendController@updateProductCategory'); //
Route::post('/json/filterproductajax','FrontendController@AjaxFilterProduct'); //
Route::post('/json/filtertierproductajax','FrontendController@FindTierPrice'); //
Route::post('/json/brandfilterproductajax','FrontendController@AjaxBrandFilterProduct')->name('ajax-brand-filter'); //
Route::post('/json/subcategoryfilterproductajax','FrontendController@AjaxFilterProductSubcat'); //
  //Route::get('/{slug}.html','FrontendController@product')->name('front.product');

 //Route::get('/{slug}.html','FrontendController@category')->name('front.category'); // Open Parent Category Page

  Route::get('/email/test','EmailController@sendMail')->name('mail.test');
