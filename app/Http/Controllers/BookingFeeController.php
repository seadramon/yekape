<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BookingFee;
use App\Models\Customer;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Kavling;
use App\Models\Nup;
use App\Models\Religion;
use App\Models\Teacher;
use Carbon\Carbon;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BookingFeeController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('pemasaran.booking-fee.index');
    }

    public function data(Request $request)
    {
        $query = BookingFee::with('kavling.cluster', 'customer', 'marketing')->select('*');

        return (new DataTables)->eloquent($query)
            ->editColumn('kavling.nama', function ($model) {
                return implode('-', [$model->kavling->nama, $model->kavling->blok, $model->kavling->nomor, $model->kavling->letak]);
            })
            ->editColumn('harga_jual', function ($model) {
                return number_format($model->harga_jual, 0, ',', '.');
            })
            ->editColumn('jumlah_pembayaran', function ($model) {
                return number_format($model->jumlah_pembayaran, 0, ',', '.');
            })
            ->addColumn('menu', function ($model) {
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                        </ul>
                        </div>';

                return $column;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create(Request $request)
    {
        $data = null;

        if($request->has('nup')){
            $nup = Nup::find($request->nup);
        }else{
            $nup = null;
        }

        $kavlings = Kavling::with('cluster')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->cluster->nama . " | " . implode('-', [$item->nama, $item->blok, $item->nomor, $item->letak])];
            })
            ->all();
        $kavlings = ['' => 'Pilih Kavling'] + $kavlings;

        $customers = Customer::select('id', 'nama')
            ->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })->all();
        $customers = ["" => "-Pilih Customer-"] + $customers;

        $marketings = Karyawan::select('id', 'nama')
            ->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })->all();
        $marketings = ["" => "-Pilih Marketing-"] + $marketings;

        $jenis = [
            "" => '-Pilih Jenis Pembayaran-',
            "transfer" => "Tunai",
            "tunia" => "Transfer"
        ];


        return view('pemasaran.booking-fee.create', [
            'kavlings' => $kavlings,
            'marketings' => $marketings,
            'customers' => $customers,
            'data' => $data,
            'nup' => $nup,
            'jenis' => $jenis,
        ]);
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'tanggal' => 'required',
                'kavling_id' => 'required',
                'customer_id' => 'required',
                'marketing_id' => 'required',
                'jenis' => 'required',
                'harga_jual' => 'required',
                'jumlah' => 'required',
            ])->validate();

            $karyawan = new BookingFee;

            $karyawan->tanggal = $request->tanggal;
            $karyawan->kavling_id = $request->kavling_id;
            $karyawan->customer_id = $request->customer_id;
            $karyawan->marketing_id = $request->marketing_id;
            $karyawan->harga_jual = str_replace(',', '.', str_replace('.', '', $request->harga_jual));
            $karyawan->jumlah_pembayaran = str_replace(',', '.', str_replace('.', '', $request->jumlah));
            $karyawan->jenis_pembayaran = $request->jenis;
            $karyawan->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('pemasaran.booking-fee.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data Teacher '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }
}
