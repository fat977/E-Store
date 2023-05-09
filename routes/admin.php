<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FilterController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SectionController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::prefix('admin')->group(function(){

    Route::get('index',[AdminController::class,'index'])->name('index');
    Route::post('login',[AdminController::class,'login'])->name('login');

    Route::group(['middleware'=>['auth:admin']],function(){
        // Admin
        Route::get('dashboard',[AdminController::class,'dashboard'])->name('dashboard');
        Route::match(['get', 'post'], 'update-password',[AdminController::class,'updatePassword']);
        Route::post('check-current-password',[AdminController::class,'checkCurrentPassword']);

        Route::match(['get', 'post'], 'update-details',[AdminController::class,'updateDetails'])->name('update-details');
        Route::get('logout',[AdminController::class,'logout'])->name('logout');

        Route::get('forgot-password-view',[AdminController::class,'forgotPasswordView']);
        Route::post('forgot-password',[AdminController::class,'forgotPassword']);

        //categories
        Route::prefix('category')->group(function(){
          Route::get('index',[CategoryController::class,'index'])->name('category.index');
          Route::get('create',[CategoryController::class,'create'])->name('category.create');
          Route::post('store',[CategoryController::class,'store'])->name('category.store');
          Route::get('edit/{id}',[CategoryController::class,'edit'])->name('category.edit');
          Route::post('update/{id}',[CategoryController::class,'update'])->name('category.update');
          Route::post('update-category-status',[CategoryController::class,'updateCategoryStatus']); 
          Route::get('append-categories',[CategoryController::class,'appendCategories']); 
          Route::get('delete-category/{id}',[CategoryController::class,'destroy']);
        });

        //sections
        Route::prefix('section')->group(function(){
          Route::get('index',[SectionController::class,'index'])->name('section.index');
          Route::get('create',[SectionController::class,'create'])->name('section.create');
          Route::post('store',[SectionController::class,'store'])->name('section.store');
          Route::get('edit/{id}',[SectionController::class,'edit'])->name('section.edit');
          Route::post('update/{id}',[SectionController::class,'update'])->name('section.update');
          Route::post('update-section-status',[SectionController::class,'updateSectionStatus']);  
          Route::get('delete-section/{id}',[SectionController::class,'destroy']);
        });

        //Brands
        Route::prefix('brand')->group(function(){
          Route::get('index',[BrandController::class,'index'])->name('brand.index');
          Route::get('create',[BrandController::class,'create'])->name('brand.create');
          Route::post('store',[BrandController::class,'store'])->name('brand.store');
          Route::get('edit/{id}',[BrandController::class,'edit'])->name('brand.edit');
          Route::post('update/{id}',[BrandController::class,'update'])->name('brand.update');
          Route::post('update-brand-status',[BrandController::class,'updateBrandStatus']);  
          Route::get('delete-brand/{id}',[BrandController::class,'destroy']);
        });

        //Banners
        Route::prefix('banner')->group(function(){
          Route::get('index',[BannerController::class,'index'])->name('banner.index');
          Route::get('create',[BannerController::class,'create'])->name('banner.create');
          Route::post('store',[BannerController::class,'store'])->name('banner.store');
          Route::get('edit/{id}',[BannerController::class,'edit'])->name('banner.edit');
          Route::post('update/{id}',[BannerController::class,'update'])->name('banner.update');
          Route::post('update-banner-status',[BannerController::class,'updateBannerStatus']);  
          Route::get('delete-banner/{id}',[BannerController::class,'deleteBanner']);
        });

        //Products
        Route::prefix('product')->group(function(){

          Route::get('index',[ProductController::class,'index'])->name('product.index');
         /*  Route::get('create',[ProductController::class,'create'])->name('product.create');
          Route::post('store',[ProductController::class,'store'])->name('product.store');
          Route::get('edit/{id}',[ProductController::class,'edit'])->name('product.edit');
          Route::post('update/{id}',[ProductController::class,'update'])->name('product.update'); */
          Route::post('update-product-status',[ProductController::class,'updateProductStatus']);  
          Route::get('delete-product/{id}',[ProductController::class,'deleteProduct']);
          Route::get('delete-product-image/{id}',[ProductController::class,'deleteProductImage']);
          Route::match(['get', 'post'], 'add-edit-product/{id?}',[ProductController::class,'addEditProduct']);
          
          Route::get('/section/{id}', [ProductController::class, 'getBrands']);

        });

        //images
        Route::prefix('image')->group(function(){
          Route::match(['get', 'post'], 'add-images/{id}',[ProductController::class,'addImages']);
          Route::post('update-image-status',[ProductController::class,'updateImageStatus']);
          Route::get('delete-image/{id}',[ProductController::class,'deleteImage']);
        });

        /////////// Attributes ////////////
        Route::prefix('attribute')->group(function(){
          Route::get('create/{id}',[ProductController::class,'create_attribute'])->name('attribute.create');
          Route::post('store/{id}',[ProductController::class,'store_attribute'])->name('attribute.store');
          Route::get('edit/{id}',[ProductController::class,'edit_attribute'])->name('attribute.edit');
          Route::post('update/{id}',[ProductController::class,'update_attribute'])->name('attribute.update');
          Route::post('update-attribute-status',[ProductController::class,'updateAttributeStatus']);  
          Route::get('delete-attribute/{id}',[ProductController::class,'deleteAttribute']);
          Route::match(['get', 'post'],'edit-attribute/{id}',[ProductController::class,'editAttribute']);
        });

       /////////// Filters ////////////
      Route::prefix('filter')->group(function(){
        Route::get('filters',[FilterController::class,'filters'])->name('filter.index');
        Route::get('filters-values',[FilterController::class,'filters_values'])->name('filter.value.index');

        Route::match(['get', 'post'], 'add-edit-filter/{id?}',[FilterController::class,'addEditFilter']);

        //Route::get('create-filter',[FilterController::class,'create_filter'])->name('filter.create');
        Route::get('create-filter-values',[FilterController::class,'create_filter_value'])->name('filter.value.create');

       // Route::post('store-filter',[FilterController::class,'store_filter'])->name('filter.store');
        Route::post('store-filter-value',[FilterController::class,'store_filter_value'])->name('filter.value.store');

        //Route::get('edit/filter/{id}',[FilterController::class,'edit_filter'])->name('filter.edit');
        Route::get('edit/filter-value/{id}',[FilterController::class,'edit_filter_value'])->name('filter.value.edit');

        //Route::post('update/filter/{id}',[FilterController::class,'update_filter'])->name('filter.update');
        Route::post('update/filter-value/{id}',[FilterController::class,'update_filter_value'])->name('filter.value.update');

        Route::post('update-filter-status',[FilterController::class,'updateFilterStatus']);
        Route::post('update-filter-value-status',[FilterController::class,'updateFilterValueStatus']); 
        
        Route::get('delete-filter/{id}',[FilterController::class,'destroy']);
        Route::get('delete-filter-value/{id}',[FilterController::class,'deleteFilterValue']);

        Route::post('category-filters',[FilterController::class,'categoryFilters']);
  
      });

      //orders
      Route::prefix('order')->group(function(){

        Route::get('orders',[OrderController::class,'orders'])->name('order');
        Route::get('view-orders/{id}',[OrderController::class,'viewOrders']);
        Route::post('update-orders/{id}',[OrderController::class,'updateOrders']);
        Route::get('orders-history',[OrderController::class,'orderHistory']);
        Route::get('MarkAsRead_all',[OrderController::class,'MarkAsRead_all'])->name('MarkAsRead_all');

      });
      
    });

});


