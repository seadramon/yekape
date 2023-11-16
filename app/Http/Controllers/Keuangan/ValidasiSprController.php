<?php

namespace App\Http\Controllers\Keuangan;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use App\Models\Kavling;
use App\Models\Customer;
use App\Models\SuratPesananRumah;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Illuminate\Routing\Controller;

class ValidasiSprController extends Controller
{

    public function index()
    {
        $tipe = [
            "" => '-Pilih Tipe-',
            "KPR" => "KPR",
            "TUNAI" => "TUNAI",
            "INHOUSE" => "INHOUSE"
        ];

    	return view('keuangan.validasi_spr.index', compact('tipe'));
    }

    public function loadData(Request $request)
    {
    	$query = SuratPesananRumah::with(['customer', 'kavling'])
    		->where('tgl_batal', null)
            ->whereNotIn('status', ['revised']);

    	if (!empty($request->tipe_pembelian)) {
    		$query->where('tipe_pembelian', $request->tipe_pembelian);
    	}

    	return DataTables::eloquent($query)
            ->editColumn('status', function ($model) {
                if($model->status == 'draft'){
                    $teks = '<span class="badge badge-outline badge-primary">' . $model->status . '</span>';
                }else{
                    $teks = '<span class="badge badge-outline badge-dark">-</span>';
                }
                return $teks;
            })
            ->addColumn('menu', function ($model) {
                $html = '<div class="btn-group">
                        <button class="btn btn-light-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="'. route('keuangan.validasi-spr.validasi', ['id' => $model->id]) .'" target="_blank">Validasi</a></li>
                        </ul>
                    </div>';

                return $html;
            })
            ->rawColumns(['menu', 'status'])
            ->toJson();
    }

    public function validasi($id = null)
    {
        $data = SuratPesananRumah::find($id);

        $tipe = [
            "" => '-Pilih Tipe-',
            "KPR" => "KPR",
            "TUNAI" => "TUNAI",
            "INHOUSE" => "INHOUSE"
        ];

        $jenis = [
            "" => '-Pilih Jenis-',
            "UMUM" => "UMUM",
            "KARYAWAN" => "KARYAWAN",
            "RUKO" => "RUKO"
        ];

        $kavling = Kavling::select('id', 'nama')
            ->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })->all();
        $kavling = ["" => "-Pilih Kavling-"] + $kavling;

        $customer = Customer::select('id', 'nama')
            ->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })->all();
        $customer = ["" => "-Pilih Customer-"] + $customer;

        return view('keuangan.validasi_spr.validasi', compact('data', 'kavling', 'customer', 'tipe', 'jenis'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            $data = SuratPesananRumah::find($request->id);
            $data->status = null;
            $data->save();

            $id = $data->id;

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
            return redirect()->route('keuangan.validasi-spr.index');
        } catch(Exception $e) {
            DB::rollback();

            $flasher->addError($e->getMessage());
            return redirect()->back();
        }
    }
}
