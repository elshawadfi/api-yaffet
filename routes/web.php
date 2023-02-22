<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Dashboard\CurrencyController;
use App\Http\Controllers\Dashboard\DashboardAuthController;
use App\Http\Controllers\Dashboard\IndexController;
use App\Http\Controllers\Dashboard\HighestPriceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/', function () {
    return view('welcome');
});


// call last prices of all metals from provider ( metal_api )
Route::get('/saveLastPrice',[AdminController::class,'saveLastPrice']);

// call historical for all metals
Route::get('/saveHistMetals/{metalName}',[AdminController::class,'saveHistMetals']);

// handleSendNotification by using job
Route::get('/send_notification',[AdminController::class,'handleSendNotification']);

// call prices for all countries ( currency )
Route::get('/saveLastCurrency',[AdminController::class,'saveLastCurrency']);


Route::get('/', function(){
    return view('login');
})->name('login')->middleware('guest');

Route::post('/sign-in', [DashboardAuthController::class, 'login'])->name('sign-in');



Route::get('/admin', [IndexController::class, 'index'])->name('admin-index');

Route::get('logout', [DashboardAuthController::class, 'logout'])->name('logout');

Route::get('/admin/profile', [DashboardAuthController::class, 'profile'])->name('profile');


/////////////////////////////// Currencies Routes /////////////////////////////////////
Route::get('admin/currencies', [CurrencyController::class, 'index'])->name('currencies-index');

Route::get('admin/currencies/create', [CurrencyController::class, 'add_currency'])->name('currencies-create');

Route::post('admin/currencies/store', [CurrencyController::class, 'store'])->name('currencies-store');

Route::get('admin/currencies/edit/{id}', [CurrencyController::class, 'edit'])->name('currencies-edit');

Route::post('admin/currencies/update/{currency}', [CurrencyController::class, 'update'])->name('currencies-update');

Route::get('admin/currencies/delete/{currency}', [CurrencyController::class, 'destroy'])->name('currencies-destroy');
/////////////////////////////// End Currencies Routes /////////////////////////////////////




/////////////////////////////// Highest Prices Routes /////////////////////////////////////
Route::get('admin/highest-prices', [HighestPriceController::class, 'index'])->name('highest-index');

Route::get('admin/highest-prices/edit/{id}', [HighestPriceController::class, 'edit'])->name('highest-edit');

Route::post('admin/highest-prices/update/{metal_price}', [HighestPriceController::class, 'update'])->name('highest-update');

Route::get('admin/highest-prices/delete/{metal_price}', [HighestPriceController::class, 'destroy'])->name('highest-destroy');