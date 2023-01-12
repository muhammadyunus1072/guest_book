<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestBookController;

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

Route::post('/reset_password', [GuestBookController::class, 'reset_password'])->name('reset_password');
Route::get('/change_password', [GuestBookController::class, 'change_password'])->name('change_password');
Route::get('/get_city', [GuestBookController::class, 'get_city'])->name('get_city');
Route::get('/get_province', [GuestBookController::class, 'get_province'])->name('get_province');

Route::prefix('guest_book')->group(function () {
    Route::name('guest_book.')->group(function () {
        Route::get('/', [GuestBookController::class, 'index'])->name('index');
        Route::get('/create', [GuestBookController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [GuestBookController::class, 'edit'])->name('edit');
        Route::get('/datatable', [GuestBookController::class, 'datatable'])->name('datatable');
        Route::post('/store', [GuestBookController::class, 'store'])->name('store');
        Route::post('/update', [GuestBookController::class, 'update'])->name('update');
        Route::delete('/destroy', [GuestBookController::class, 'destroy'])->name('destroy');
    });
});

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');
