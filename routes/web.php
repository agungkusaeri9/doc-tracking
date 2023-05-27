<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryDetailController;
use App\Http\Controllers\UnitKerjaController;
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

Route::redirect('/', '/login', 301);

Auth::routes();

// admin
Route::middleware('auth')->prefix('admin')->group(function(){
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::resource('users',UserController::class);
    Route::get('/profile',[ProfileController::class,'index'])->name('profile.index');
    Route::post('/profile',[ProfileController::class,'update'])->name('profile.update');



    // categories
    Route::get('categories/data',[CategoryController::class,'data'])->name('categories.data');
    Route::resource('categories', CategoryController::class);

    // category-details
    Route::get('category-details/data',[CategoryDetailController::class,'data'])->name('category-details.data');
    Route::resource('category-details', CategoryDetailController::class);

     // unit-kerjas
     Route::get('unit-kerjas/data',[UnitKerjaController::class,'data'])->name('unit-kerjas.data');
     Route::get('unit-kerjas/get',[UnitKerjaController::class,'get'])->name('unit-kerjas.get-json');
     Route::resource('unit-kerjas', UnitKerjaController::class);
});
