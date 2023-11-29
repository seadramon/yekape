<?php

use App\Http\Controllers\BookingFeeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TanahKavlingController;
use App\Http\Controllers\TanahMentahController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Keuangan\ValidasiSprController;
use App\Http\Controllers\KwitansiController;
use App\Http\Controllers\NupController;
use App\Http\Controllers\SuratPesananController;

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

Route::group(['prefix' => '/dashboard', 'as' => 'dashboard.'], function(){
	Route::get('spr-monthly', [DashboardController::class, 'sprMonthly'])->name('spr-monthly');
	Route::resource('/', DashboardController::class)->only(['index'])->parameters(['' => 'id']);
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

	Route::group(['prefix' => '/tanah-mentah', 'as' => 'tanah-mentah.'], function(){

		Route::get('/', 			[TanahMentahController::class, 'index'])->name('index');
		Route::get('loadData', 		[TanahMentahController::class, 'loadData'])->name('data');
		Route::get('create/{id?}', 	[TanahMentahController::class, 'create'])->name('create');
		Route::post('store', 		[TanahMentahController::class, 'store'])->name('store');
		Route::post('/destroy', 	[TanahMentahController::class, 'destroy'])->name('destroy');
	});

	Route::group(['prefix' => '/cluster', 'as' => 'cluster.'], function(){

		Route::get('/', 			[ClusterController::class, 'index'])->name('index');
		Route::get('loadData', 		[ClusterController::class, 'loadData'])->name('data');
		Route::get('create/{id?}', 	[ClusterController::class, 'create'])->name('create');
		Route::post('store', 		[ClusterController::class, 'store'])->name('store');
		Route::post('/destroy', 	[ClusterController::class, 'destroy'])->name('destroy');
	});
});

Route::group(['prefix' => '/pemasaran', 'as' => 'pemasaran.'], function(){

	Route::group(['prefix' => '/suratpesanan', 'as' => 'suratpesanan.'], function(){
        Route::get('/loadData', [SuratPesananController::class, 'loadData'])->name('data');
        Route::get('/exportExcel', [SuratPesananController::class, 'exportExcel'])->name('export-excel');
		Route::post('/destroy', [SuratPesananController::class, 'destroy'])->name('destroy');
		Route::get('cetak/{id}', 	[SuratPesananController::class, 'cetak'])->name('cetak');
		Route::get('cetakppjb/{id?}', 	[SuratPesananController::class, 'cetakppjb'])->name('cetakppjb');
		Route::get('{id}/revisi', 	[SuratPesananController::class, 'revisi'])->name('revisi');
		Route::put('{id}/revisi', 	[SuratPesananController::class, 'revisiStore'])->name('revisi-store');
		Route::get('{id}/upload', 	[SuratPesananController::class, 'upload'])->name('upload');
		Route::put('{id}/upload', 	[SuratPesananController::class, 'uploadStore'])->name('upload-store');
		Route::resource('/', SuratPesananController::class)->except(['destroy'])->parameters(['' => 'spr']);
	});

	Route::group(['prefix' => '/nup', 'as' => 'nup.'], function(){

		Route::get('/data', [NupController::class, 'data'])->name('data');
		Route::post('/destroy', [NupController::class, 'destroy'])->name('destroy');
		Route::resource('/', NupController::class)->except(['destroy'])->parameters(['' => 'nup']);
	});
	Route::group(['prefix' => '/booking-fee', 'as' => 'booking-fee.'], function(){

		Route::get('/data', [BookingFeeController::class, 'data'])->name('data');
		Route::post('/destroy', [BookingFeeController::class, 'destroy'])->name('destroy');
		Route::resource('/', BookingFeeController::class)->except(['destroy'])->parameters(['' => 'booking-fee']);
	});
});

Route::group(['prefix' => '/karyawan', 'as' => 'karyawan.'], function(){

	Route::get('/data', [KaryawanController::class, 'data'])->name('data');
	Route::post('/destroy', [KaryawanController::class, 'destroy'])->name('destroy');
	Route::resource('/', KaryawanController::class)->except(['destroy'])->parameters(['' => 'karyawan']);
});


Route::group(['prefix' => '/kwitansi', 'as' => 'kwitansi.'], function(){
	Route::get('/data', [KwitansiController::class, 'data'])->name('data');
	Route::get('/create-{tipe}', [KwitansiController::class, 'create'])->name('create');
	// Route::get('/create/kwu', [KwitansiController::class, 'createKwu'])->name('create-kwu');
	Route::get('/cetak/{id}', 	[KwitansiController::class, 'cetak'])->name('cetak');
	Route::post('/destroy', [KwitansiController::class, 'destroy'])->name('destroy');
	Route::get('/source-data', [KwitansiController::class, 'sourceData'])->name('source-data');
	Route::resource('/', KwitansiController::class)->except(['destroy', 'create'])->parameters(['' => 'kwitansi']);
});

Route::group(['prefix' => '/keuangan', 'as' => 'keuangan.'], function(){

	Route::group(['prefix' => '/validasi-spr', 'as' => 'validasi-spr.'], function(){
        Route::get('/loadData', [ValidasiSprController::class, 'loadData'])->name('data');
		Route::get('{id}/validasi', [ValidasiSprController::class, 'validasi'])->name('validasi');
		Route::resource('/', ValidasiSprController::class)->except(['destroy'])->parameters(['' => 'spr']);
	});
});
