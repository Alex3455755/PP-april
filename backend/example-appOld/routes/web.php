<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\CloutheController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonalController;


Route::get('/', [SaleController::class,'index'])->name("sale.index");
Route::get('/sale/{sale}', [SaleController::class,'detail'])->name("sale.detail");

Route::get('/register',[RegisterController::class, 'registerform'])->name('auth.register');
Route::post('/register',[RegisterController::class, 'register'])->name('auth.register');


Route::get('/login',[LoginController::class, 'loginform'])->name('auth.login');
Route::post('/login',[LoginController::class, 'login'])->name('auth.login');

Route::get('/logout', function(){
    auth()->logout();
    return redirect()->route('auth.login');

})->name('auth.logout')->middleware('auth');


// personal
Route::get('/personal',[PersonalController::class,'index'])->name('personal.index');
Route::get('/personal/add',[PersonalController::class,'showAddSaleForm'])->name('personal.add');
Route::post('/personal',[PersonalController::class,'storeSale'])->name('personal.store');

Route::get('/personal/{sale}/edit',[PersonalController::class,'showEditSaleForm'])->name('personal.edit')->middleware('can:update,sale');
Route::patch('/personal/{sale}',[PersonalController::class,'updateSale'])->name('personal.update')->middleware('can:update,sale');
Route::get('/personal/{sale}/delete',[PersonalController::class,'showDeleteSaleForm'])->name('personal.delete')->middleware('can:delete,sale');
Route::delete('/personal/{sale}',[PersonalController::class,'destroySale'])->name('personal.destroy')->middleware('can:delete,sale');

Route::get('/personal/{sale}',[PersonalController::class,'detail'])->name('personal.detail');


// brand
Route::get('/brand', [BrandController::class,'index'])->name("brand.list");
Route::get('/brand/add',[BrandController::class,'showAddBrandForm'])->name('brand.add');
Route::post('/brand',[BrandController::class,'storeBrand'])->name('brand.store');
Route::get('/brand/{brand}', [BrandController::class,'detail'])->name("brand.detail");

Route::get('/brand/{brand}/edit',[BrandController::class,'showEditSaleForm'])->name('brand.edit')->middleware('can:update,brand');
Route::patch('/brand/{brand}',[BrandController::class,'updateBrand'])->name('brand.update')->middleware('can:update,brand');
Route::get('/brand/{brand}/delete',[BrandController::class,'showDeleteBrandForm'])->name('brand.delete')->middleware('can:delete,brand');
Route::delete('/brand/{brand}',[BrandController::class,'destroyBrand'])->name('brand.destroy')->middleware('can:delete,brand');


// Clouthes
Route::get('/clouthe', [CloutheController::class, 'index'])->name('clothes.list');
Route::get('/clouthe/add', [CloutheController::class, 'showAddBrandForm'])->name('clothes.add');
Route::post('/clouthe', [CloutheController::class, 'storeBrand'])->name('clothes.store');
Route::get('/clouthe/{clouthe}', [CloutheController::class, 'detail'])->name('clothes.detail');
Route::get('/clouthe/{clouthe}/edit', [CloutheController::class, 'showEditClotheForm'])->name('clothes.edit')->middleware('can:update,clouthe');
Route::patch('/clouthe/{clouthe}', [CloutheController::class, 'updateClothe'])->name('clothes.update')->middleware('can:update,clouthe');
Route::get('/clouthe/{clouthe}/delete', [CloutheController::class, 'showDeleteBrandForm'])->name('clothes.delete')->middleware('can:delete,clouthe');
Route::delete('/clouthe/{clouthe}', [CloutheController::class, 'destroyBrand'])->name('clothes.destroy')->middleware('can:delete,clouthe');