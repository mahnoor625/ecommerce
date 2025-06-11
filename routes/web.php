<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\middleware\AuthAdmin;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use  App\Http\Controllers\UserController;
use  App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});
 Route::get('/',[StoreController::class,'index']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');
Route::get('/shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product_slug}', [ShopController::class, 'product_detail'])->name('shop.product.detail');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');




Route::middleware(['auth'])->group(function(){
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
});

Route::middleware(['auth',AuthAdmin::class])->group(function(){
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route:: get('/admin/brand',[AdminController::class,'brand'])->name('admin.brands');
    Route:: get('/admin/brand/add',[AdminController::class,'AddBrands'])->name('admin.brands.add');
    Route::post('/admin/brand/store',[AdminController::class,'brand_store'])->name('admin.brands.store');
    Route::get('/admin/brand/edit/{id}', [AdminController::class, 'brand_edit'])->name('admin.brand.edit'); 
    Route::put('/admin/brand/update', [AdminController::class, 'brand_update'])->name('admin.brand.update');
    Route::delete('/admin/brand/{id}/delete', [AdminController::class, 'brand_delete'])->name('admin.brand.delete');


    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route:: get('/admin/categories/add',[AdminController::class,'AddCategory'])->name('admin.categories.add');
    Route::post('/admin/categories/store',[AdminController::class,'category_store'])->name('admin.categories.store');
    Route::get('/admin/categories/edit/{id}', [AdminController::class, 'category_edit'])->name('admin.categories.edit'); 
    Route::put('/admin/categories/update', [AdminController::class, 'category_update'])->name('admin.categories.update');
    Route::delete('/admin/categories/{id}/delete', [AdminController::class, 'category_delete'])->name('admin.categories.delete');

    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route:: get('/admin/products/add',[AdminController::class,'addProduct'])->name('admin.products.add');
    Route::post('/admin/products/store',[AdminController::class,'product_store'])->name('admin.products.store');
    Route::get('/admin/products/{id}/edit',[AdminController::class,'product_edit'])->name('admin.products.edit');
    Route::put('/admin/products/update', [AdminController::class, 'product_update'])->name('admin.products.update');
    Route::delete('/admin/products/{id}/delete', [AdminController::class, 'product_delete'])->name('admin.products.delete');





    

});


