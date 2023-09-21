<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\TransactionController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
route::get('/login',[LoginController::class,'login'])->name('login');
route::post('/login_check',[LoginController::class,'loginCheck'])->name('login.check');
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class,'logout'])->name('logout');
    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::resource('/user', UserController::class);
    Route::get('/tranasction', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/tranasction', [TransactionController::class, 'store'])->name('transaction.store');

});

