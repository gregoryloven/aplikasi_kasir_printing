<?php

use App\Http\Controllers\CashierController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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

route::middleware(['auth'])->group(function(){

Route::get('/', [ProductController::class, 'index']);

Route::resource('product', ProductController::class);
Route::post('/product/EditForm', [ProductController::class, 'EditForm'])->name('product.EditForm');


Route::resource('cashier', CashierController::class);

Route::get('addTransaction', [CashierController::class, 'create']);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
