<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TanahKavlingController;
use App\Http\Controllers\CustomerController;

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

Route::get('/', function () {
    return view('template');
});
Route::get('template', function () {
    return view('template');
});

Route::group(['prefix' => '/master', 'as' => 'master.'], function(){

	Route::group(['prefix' => '/tanah-kavling', 'as' => 'tanah-kavling.'], function(){	

		Route::get('/', 		[TanahKavlingController::class, 'index'])->name('index');
		Route::get('loadData', 	[TanahKavlingController::class, 'loadData'])->name('data');
		Route::get('create', 	[TanahKavlingController::class, 'create'])->name('create');
		Route::get('edit/{id}', 		[TanahKavlingController::class, 'edit'])->name('edit');
		Route::post('store', 	[TanahKavlingController::class, 'store'])->name('store');
		Route::post('/destroy', [TanahKavlingController::class, 'destroy'])->name('destroy');
	});

	Route::group(['prefix' => '/customer', 'as' => 'customer.'], function(){	

		Route::get('/', 			[CustomerController::class, 'index'])->name('index');
		Route::get('loadData', 		[CustomerController::class, 'loadData'])->name('data');
		Route::get('create/{id?}', 	[CustomerController::class, 'create'])->name('create');
		Route::post('store', 		[CustomerController::class, 'store'])->name('store');
		Route::post('/destroy', 	[CustomerController::class, 'destroy'])->name('destroy');
	});
});
