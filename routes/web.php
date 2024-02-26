<?php

use App\Http\Controllers\BookingFeeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\TanahKavlingController;
use App\Http\Controllers\TanahMentahController;
use App\Http\Controllers\ClusterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Keuangan\PengajuanKegiatanController;
use App\Http\Controllers\Keuangan\ValidasiKegiatanDetailController;
use App\Http\Controllers\Keuangan\ValidasiPengajuanKegiatanController;
use App\Http\Controllers\Keuangan\ValidasiSprController;
use App\Http\Controllers\KwitansiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ManajemenUser\RoleController;
use App\Http\Controllers\ManajemenUser\UserController;
use App\Http\Controllers\NupController;
use App\Http\Controllers\Perencanaan\HspkController;
use App\Http\Controllers\Perencanaan\KegiatanController;
use App\Http\Controllers\Perencanaan\KegiatanDetailController;
use App\Http\Controllers\Perencanaan\MisiController;
use App\Http\Controllers\Perencanaan\ProgramController;
use App\Http\Controllers\Perencanaan\SasaranController;
use App\Http\Controllers\Perencanaan\SshController;
use App\Http\Controllers\Perencanaan\VisiController;
use App\Http\Controllers\SuratPesananController;
use App\Http\Controllers\StokKavlingController;
use App\Http\Controllers\SerapanController;
use App\Http\Controllers\BagianController;

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
		Route::get('kavling-per-cluster', [DashboardController::class, 'kavlingPerCluster'])->name('kavling-per-cluster');
		Route::get('tanah-mentah-per-kota', [DashboardController::class, 'tanahMentahPerKota'])->name('tanah-mentah-per-kota');
		Route::resource('/', DashboardController::class)->only(['index'])->parameters(['' => 'id']);
	});
	
	Route::group(['prefix' => '/master', 'as' => 'master.'], function(){
	
		Route::group(['prefix' => '/bagian', 'as' => 'bagian.'], function(){
	
			Route::get('/', 		[BagianController::class, 'index'])->name('index');
			Route::get('loadData', 	[BagianController::class, 'loadData'])->name('data');
			Route::get('create', 	[BagianController::class, 'create'])->name('create');
			Route::get('edit/{id}', 		[BagianController::class, 'edit'])->name('edit');
			Route::post('store', 	[BagianController::class, 'store'])->name('store');
			Route::post('/destroy', [BagianController::class, 'destroy'])->name('destroy');
		});
		
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
			Route::post('store-sppk', [SuratPesananController::class, 'storeSppk'])->name('sppk');
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
		Route::get('/exportExcel', [KwitansiController::class, 'exportExcel'])->name('export-excel');
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

		Route::group(['prefix' => 'pengajuan-kegiatan', 'as' => 'pengajuan-kegiatan.'], function(){
			Route::get('/data', [PengajuanKegiatanController::class, 'data'])->name('data');
			Route::get('/cetak/{id}', 	[PengajuanKegiatanController::class, 'cetak'])->name('cetak');
			Route::post('/destroy', [PengajuanKegiatanController::class, 'destroy'])->name('destroy');
			Route::resource('/', PengajuanKegiatanController::class)->except(['destroy'])->parameters(['' => 'pengajuan-kegiatan']);
		});

		Route::group(['prefix' => 'validasi-rincian-kegiatan', 'as' => 'validasi-kegiatan-detail.'], function(){
			Route::get('/data', [ValidasiKegiatanDetailController::class, 'data'])->name('data');
			Route::get('/exportExcel', [ValidasiKegiatanDetailController::class, 'exportExcel'])->name('export-excel');
			Route::post('/destroy', [ValidasiKegiatanDetailController::class, 'destroy'])->name('destroy');
			Route::resource('/', ValidasiKegiatanDetailController::class)->except(['destroy', 'create'])->parameters(['' => 'validasi-kegiatan-detail']);
		});
		
		Route::group(['prefix' => 'validasi-pengajuan-kegiatan', 'as' => 'validasi-pengajuan-kegiatan.'], function(){
			Route::get('/data', [ValidasiPengajuanKegiatanController::class, 'data'])->name('data');
			Route::get('/cetak/{id}', 	[ValidasiPengajuanKegiatanController::class, 'cetak'])->name('cetak');
			Route::post('/destroy', [ValidasiPengajuanKegiatanController::class, 'destroy'])->name('destroy');
			Route::resource('/', ValidasiPengajuanKegiatanController::class)->except(['destroy'])->parameters(['' => 'validasi-pengajuan-kegiatan']);
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
		Route::group(['prefix' => '/sasaran', 'as' => 'sasaran.'], function(){
			Route::get('/data', [SasaranController::class, 'data'])->name('data');
			Route::post('/destroy', [SasaranController::class, 'destroy'])->name('destroy');
			Route::resource('/', SasaranController::class)->except(['destroy'])->parameters(['' => 'sasaran']);
		});
		Route::group(['prefix' => '/program', 'as' => 'program.'], function(){
			Route::get('/data', [ProgramController::class, 'data'])->name('data');
			Route::post('/destroy', [ProgramController::class, 'destroy'])->name('destroy');
			Route::resource('/', ProgramController::class)->except(['destroy'])->parameters(['' => 'program']);
		});
		Route::group(['prefix' => 'kegiatan', 'as' => 'kegiatan.'], function(){
			Route::get('/data', [KegiatanController::class, 'data'])->name('data');
			Route::post('/destroy', [KegiatanController::class, 'destroy'])->name('destroy');
			Route::resource('/', KegiatanController::class)->except(['destroy'])->parameters(['' => 'kegiatan']);
		});
		Route::group(['prefix' => 'rincian-kegiatan', 'as' => 'kegiatan-detail.'], function(){
			Route::get('/data', [KegiatanDetailController::class, 'data'])->name('data');
			Route::get('/exportExcel', [KegiatanDetailController::class, 'exportExcel'])->name('export-excel');
			Route::post('/destroy', [KegiatanDetailController::class, 'destroy'])->name('destroy');
			Route::resource('/', KegiatanDetailController::class)->except(['destroy', 'create', 'store'])->parameters(['' => 'kegiatan-detail']);
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
		Route::group(['prefix' => '/user', 'as' => 'user.'], function(){
			Route::get('/data', [UserController::class, 'data'])->name('data');
			Route::get('/ganti-password/{id}', [UserController::class, 'gantiPasswordLink'])->name('ganti-password');
			Route::post('/ganti-password/{id}', [UserController::class, 'gantiPasswordStore'])->name('ganti-password');
			Route::post('/destroy', [UserController::class, 'destroy'])->name('destroy');
			Route::resource('/', UserController::class)->except(['destroy'])->parameters(['' => 'user']);
		});
	});

	Route::group(['prefix' => '/monitoring', 'as' => 'monitoring.'], function(){
		Route::group(['prefix' => '/stokkavling', 'as' => 'stokkavling.'], function(){
		
			Route::get('/data', [StokKavlingController::class, 'data'])->name('data');
			Route::post('/destroy', [StokKavlingController::class, 'destroy'])->name('destroy');
			Route::resource('/', StokKavlingController::class)->except(['destroy'])->parameters(['' => 'stokkavling']);
		});

		Route::group(['prefix' => '/serapan', 'as' => 'serapan.'], function(){
			Route::get('/', [SerapanController::class, 'index'])->name('index');
			Route::post('/data', [SerapanController::class, 'data'])->name('data');
		});
	});
});
