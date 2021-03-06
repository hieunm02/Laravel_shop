<?php

use App\Http\Controllers\Admin\CartController as AdminCartController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\MainController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\UploadController;
use App\Http\Controllers\Admin\Users\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\LoginController as ControllersLoginController;
use App\Http\Controllers\MainController as ControllersMainController;
use App\Http\Controllers\MenuController as ControllersMenuController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Models\Customer;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('admin')->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/', [MainController::class, 'index'])->name('admin');
        Route::get('main', [MainController::class, 'index']);


        //Menu
        Route::prefix('menus')->group(function () {
            Route::get('add', [MenuController::class, 'create']);
            Route::post('add', [MenuController::class, 'store']);
            Route::get('list', [MenuController::class, 'index']);
            Route::get('edit/{menu}', [MenuController::class, 'show']);
            Route::post('edit/{menu}', [MenuController::class, 'update']);
            Route::DELETE('destroy', [MenuController::class, 'destroy']);
        });

        //Product
        Route::prefix('products')->group(function () {
            Route::get('add', [ProductController::class, 'create']);
            Route::post('add', [ProductController::class, 'store']);
            Route::get('list', [ProductController::class, 'index']);
            Route::get('edit/{product}', [ProductController::class, 'show']);
            Route::post('edit/{product}', [ProductController::class, 'update']);
            Route::DELETE('destroy', [ProductController::class, 'destroy']);
        });

        //Slider
        Route::prefix('sliders')->group(function () {
            Route::get('add', [SliderController::class, 'create']);
            Route::post('add', [SliderController::class, 'store']);
            Route::get('list', [SliderController::class, 'index']);
            Route::get('edit/{slider}', [SliderController::class, 'show']);
            Route::post('edit/{slider}', [SliderController::class, 'update']);
            Route::DELETE('destroy', [SliderController::class, 'destroy']);
        });

        //upload
        Route::post('upload/services', [UploadController::class, 'store']);

        //cart
        Route::get('customers', [AdminCartController::class, 'index']);
        Route::post('customers/update', [AdminCartController::class, 'update'])->name('customer/update');

        Route::get('customers/view/{customer}', [AdminCartController::class, 'show']);

        //User
        Route::get('user-account', [UserController::class, 'index']);
        Route::post('lock-account', [UserController::class, 'lock'])->name('lock-account');
        Route::post('unlock-account', [UserController::class, 'unlock'])->name('unlock-account');

        //Review
        Route::get('reviews', [ReviewController::class, 'index']);
        Route::post('lock-review', [ReviewController::class, 'lock'])->name('lock-review');
        Route::post('unlock-review', [ReviewController::class, 'unlock'])->name('unlock-review');

        //Contact
        Route::get('contacts', [AdminContactController::class, 'index']);
    });
});

//????ng nh???p trang qu???n tr???
Route::get('admin/users/login', [LoginController::class, 'index'])->name('login');
Route::post('admin/users/login/store', [LoginController::class, 'store']);

//Trang ch???
Route::get('/', [ControllersMainController::class, 'index']);

//Xem th??m s???n ph???m
Route::post('/services/load-product', [ControllersMainController::class, 'loadProduct']);

//Danh m???c s???n ph???m
Route::get('danh-muc/{id}-{slug}', [ControllersMenuController::class, 'index']);

//Chi ti???t s???n ph???m
Route::get('san-pham/{id}-{slug}', [ControllersProductController::class, 'index']);

//B??nh lu???n s???n ph???m
Route::post('san-pham/{id}-{slug}', [ControllersProductController::class, 'review']);

//G??? b??nh lu???n s???n ph???m
Route::delete('san-pham/{id}-{slug}', [ControllersProductController::class, 'deleteReview']);

//Gi??? h??ng
Route::post('add-cart', [CartController::class, 'index']);
Route::get('carts', [CartController::class, 'show']);
Route::post('/update-cart', [CartController::class, 'update']);
Route::get('carts/delete/{id}', [CartController::class, 'remove']);


Route::middleware('user_login')->group( function () {

    // Mua h??ng
    Route::post('carts', [CartController::class, 'addCart']);

    //Danh s??ch ????n h??ng ph??a ng?????i d??ng
    Route::get('/order_user/{id}/menu/{menuId?}', [CartController::class, 'order']);

    //H???y ????n h??ng
    Route::post('/update-order', [CartController::class, 'updateOrder'])->name('/huy-don');
    
});




//login with google
Route::get('/auth/google/redirect', [AuthController::class, 'googleredirect']);
Route::get('/auth/google/redirect', [AuthController::class, 'googleredirect'])->name('login/google/admin');

Route::get('/auth/google/callback', [AuthController::class, 'googlecallback']);

//form login
Route::get('/user_login', [ControllersLoginController::class, 'index']);

//logout
Route::get('/logout', [ControllersLoginController::class, 'logout']);

//Form contact
Route::get('/form-contact', [ContactController::class, 'index']);
Route::post('/form-contact', [ContactController::class, 'post']);


