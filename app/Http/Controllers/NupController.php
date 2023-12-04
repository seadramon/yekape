<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

class NupController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('pemasaran.nup.index');
    }

    public function data(Request $request)
    {
        $query = Nup::with('kavling.cluster', 'customer', 'marketing')->select('*');

        return (new DataTables)->eloquent($query)
            ->editColumn('kavling.nama', function ($model) {
                return implode('-', [$model->kavling->nama, $model->kavling->blok, $model->kavling->nomor, $model->kavling->letak]);
            })
            ->editColumn('biaya', function ($model) {
                return number_format($model->biaya, 0, ',', '.');
            })
            ->addColumn('menu', function ($model) {
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="'.route('pemasaran.booking-fee.create', ['nup' => $model->id]).'" target="_blank">Buat Booking Fee</a></li>
                        </ul>
                        </div>';

                return $column;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create()
    {
        $data = null;
        
        $kavlings = Kavling::with('cluster')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->id => ($item->cluster->nama ?? 'Unknown') . " | " . implode('-', [$item->nama, $item->blok, $item->nomor, $item->letak])];
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

        return view('pemasaran.nup.create', [
            'kavlings' => $kavlings,
            'marketings' => $marketings,
            'customers' => $customers,
            'data' => $data,
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
            ])->validate();

            $karyawan = new Nup;

            $karyawan->tanggal = $request->tanggal;
            $karyawan->kavling_id = $request->kavling_id;
            $karyawan->customer_id = $request->customer_id;
            $karyawan->marketing_id = $request->marketing_id;
            $karyawan->biaya = str_replace(',', '.', str_replace('.', '', $request->biaya));
            $karyawan->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('pemasaran.nup.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data Teacher '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }
}
