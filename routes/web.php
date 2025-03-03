<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\middleware\AuthAdmin;
use App\Http\Controllers\AdminController;
use  App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});
 Route::get('/',[StoreController::class,'index']);
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');


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
});


