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
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenUser\RoleController;
use App\Http\Controllers\NupController;
use App\Http\Controllers\Perencanaan\HspkController;
use App\Http\Controllers\Perencanaan\MisiController;
use App\Http\Controllers\Perencanaan\SshController;
use App\Http\Controllers\Perencanaan\VisiController;
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

Route::get('/login',	[LoginController::class, 'index'])->name('login');
Route::post('/login',	[LoginController::class, 'postLogin'])->name('post-login');
Route::get('logout',	[LoginController::class, 'signOut'])->name('logout');

Route::get('template', function () {
	return view('template');
});

Route::middleware('auth')->group(function () {
	Route::get('/', function () {
		// return view('template');
		return redirect()->route('dashboard.index');
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
			Route::get('search', 		[CustomerController::class, 'searchCustomer'])->name('search');
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
	Route::group(['prefix' => '/perencanaan', 'as' => 'perencanaan.'], function(){
		Route::group(['prefix' => '/ssh', 'as' => 'ssh.'], function(){
			Route::get('/data', [SshController::class, 'data'])->name('data');
			Route::post('/destroy', [SshController::class, 'destroy'])->name('destroy');
			Route::resource('/', SshController::class)->except(['destroy'])->parameters(['' => 'ssh']);
		});

		Route::group(['prefix' => '/hspk', 'as' => 'hspk.'], function(){
			Route::get('/data', [HspkController::class, 'data'])->name('data');
			Route::post('/destroy', [HspkController::class, 'destroy'])->name('destroy');
			Route::resource('/', HspkController::class)->except(['destroy'])->parameters(['' => 'ssh']);
		});

		Route::group(['prefix' => '/visi', 'as' => 'visi.'], function(){
			Route::get('/data', [VisiController::class, 'data'])->name('data');
			Route::post('/destroy', [VisiController::class, 'destroy'])->name('destroy');
			Route::resource('/', VisiController::class)->except(['destroy'])->parameters(['' => 'visi']);
		});

		Route::group(['prefix' => '/misi', 'as' => 'misi.'], function(){
			Route::get('/data', [MisiController::class, 'data'])->name('data');
			Route::post('/destroy', [MisiController::class, 'destroy'])->name('destroy');
			Route::resource('/', MisiController::class)->except(['destroy'])->parameters(['' => 'misi']);
		});
	});

	Route::group(['prefix' => '/manajemen-user', 'as' => 'manajemen-user.'], function(){
		Route::group(['prefix' => '/role', 'as' => 'role.'], function(){
			Route::get('/data', [RoleController::class, 'data'])->name('data');
			Route::post('/destroy', [RoleController::class, 'destroy'])->name('destroy');
			Route::get('/setting-menu/{id}', [RoleController::class, 'settingMenu'])->name('setting-menu');
			Route::post('/setting-menu-update', [RoleController::class, 'settingMenuUpdate'])->name('setting-menu.update');
			Route::post('/setting-menu-tree-data', [RoleController::class, 'settingMenuTreeData'])->name('setting-menu.tree-data');
			Route::get('/setting-menu-delete/{id}', [RoleController::class, 'settingMenuDelete'])->name('setting-menu.delete');
			Route::resource('/', RoleController::class)->except(['destroy'])->parameters(['' => 'role']);
		});
	});
});
