<?php

use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\RatingController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\WishlistController;
use App\Http\Controllers\WishlistConroller;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); */
Route::namespace('Front')->group(function(){
    Route::get('test',[ProductController::class,'test']);
    Route::get('/',[IndexController::class,'index']);

    // listing / categories 
    $catUrls = Category::select('url')->where('status',1)->get()->pluck('url')->toArray();
    foreach($catUrls as $key=>$url){
        Route::match(['get', 'post'],'/'.$url,[ProductController::class,'listing']);
    }

    //product detail page
    Route::get('/product/{id}',[ProductController::class,'details']);

    // get products price
    Route::post('get-products-price',[ProductController::class,'getProductsPrice']);

    Route::prefix('cart')->group(function(){
        // add to cart
        Route::post('add',[CartController::class,'cartAdd']);
        Route::post('update',[CartController::class,'cartUpdate']);
        Route::post('delete',[CartController::class,'cartDelete']);
        // cart
        Route::get('/cart',[CartController::class,'cart']);
    });

    Route::prefix('wishlist')->group(function(){
        // add to wishlist
        Route::post('add-to-wishlist',[WishlistController::class,'addToWishlist']);
        Route::post('update',[WishlistController::class,'wishlistUpdate']);
        Route::post('delete-wishlist-item',[WishlistController::class,'wishlistDelete']);
        Route::get('load-wishlist-count', [WishlistController::class,'wishlistCount']);
       
    });

    //user login/ register
    Route::get('user/login-register',[UserController::class,'loginRegister'])->name('login');
    Route::post('user/register',[UserController::class,'userRegister']);
    Route::post('user/login',[UserController::class,'userLogin']);

    //user forgot password
    Route::match(['get','post'],'user/forgot-password',[UserController::class,'forgotPassword']);

    //auth middleware
    Route::group(['middleware'=>['auth']],function(){
        //user account
        Route::match(['get','post'],'user/account',[UserController::class,'userAccount']);
        // update password
        Route::post('user/update-password',[UserController::class,'userUpdatePassword']);

        Route::post('user/check-current-password',[UserController::class,'checkCurrentPassword']);

        Route::get('user/change-password',[UserController::class,'changePassword']);
        Route::post('user/create-new-password',[UserController::class,'createNewPassword']);

         // wishlist
         Route::get('/wishlist',[WishlistController::class,'wishlist'])->name('wishlist');

        //checkout
        Route::post('place-order', [CheckController::class,'placeOrder']);

         //orders
         Route::get('my-orders', [UserController::class,'orders'])->name('orders');
         Route::get('view-orders/{id}', [UserController::class,'viewOrders']);

        //rating
        Route::post('add-rating', [RatingController::class,'add']);
        Route::get('edit-review/{id}', [RatingController::class,'edit']);
        Route::post('update-review', [RatingController::class,'update']);
        Route::post('delete-review', [RatingController::class,'delete']);

    });
    Route::get('/checkout', [CheckController::class,'checkout'])->name('checkout');


    // user logout
    Route::get('user/logout',[UserController::class,'userLogout']);

    // confirm user
    Route::get('user/confirm/{code}',[UserController::class,'userConfirm']);


});
