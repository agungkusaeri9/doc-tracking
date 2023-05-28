<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryDetailController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LetterController;
use App\Http\Controllers\RoleController;
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
Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');



    // categories
    Route::get('categories/data', [CategoryController::class, 'data'])->name('categories.data');
    Route::resource('categories', CategoryController::class);

    // category-details
    Route::get('category-details/data', [CategoryDetailController::class, 'data'])->name('category-details.data');
    Route::resource('category-details', CategoryDetailController::class);

    // unit-kerjas
    Route::get('unit-kerjas/data', [UnitKerjaController::class, 'data'])->name('unit-kerjas.data');
    Route::get('unit-kerjas/get', [UnitKerjaController::class, 'get'])->name('unit-kerjas.get-json');
    Route::post('unit-kerjas/set-role', [UnitKerjaController::class, 'set_role'])->name('unit-kerjas.set-role');
    Route::resource('unit-kerjas', UnitKerjaController::class);


    // jabatans
    Route::get('jabatans/data', [JabatanController::class, 'data'])->name('jabatans.data');
    Route::get('jabatans/getbyunitkerja', [JabatanController::class, 'get_by_unitkerja'])->name('jabatans.get-byunitkerja');
    Route::resource('jabatans', JabatanController::class);

    // roles
    Route::get('roles/data', [RoleController::class, 'data'])->name('roles.data');
    Route::get('roles/get', [RoleController::class, 'get'])->name('roles.get-json');
    Route::get('roles/getbyunitkerja', [RoleController::class, 'get_by_unitkerja'])->name('roles.get-byunitkerja');
    Route::resource('roles', RoleController::class);


    // users
    Route::get('users/data', [UserController::class, 'data'])->name('users.data');
    Route::resource('users', UserController::class);

    // create letter
    // surat umum
    Route::get('/letter/create',[LetterController::class,'create'])->name('letters.create');
    Route::post('/letter/create',[LetterController::class,'store'])->name('letters.store');
});
