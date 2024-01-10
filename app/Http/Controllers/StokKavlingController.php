<?php

namespace App\Http\Controllers;

use App\Models\Kavling;
use App\Models\CLuster;
use Carbon\Carbon;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class StokKavlingController extends Controller
{
    //
    public function index()
    {
        $lokasi = [
            "" => "---Pilih Lokasi---",
            "SURABAYA" => "SURABAYA",
            "GRESIK" => "GRESIK"
        ];

        $cluster = Cluster::all()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $cluster = ["" => "---Pilih Cluster---"] + $cluster;

        $status = ["" => "---Pilih Status---",
            '1' => "Terjual/AJB",
            '2' => "Rumah Contoh",
            '3' => "Rumah Dalam Proses",
            '4' => "Rumah Booked",
            '5' => "Tanah Kavling",
            '6' => "Stok Rumah Jadi",
            '7' => "Aset Terjual Belum Lepas",
            '8' => "Fasum",
            '9' => "Kavling Belum Pecah Induk"
        ];

    	return view('monitoring.stokkavling.index', compact('lokasi', 'cluster', 'status'));
    }

    public function data(Request $request)
    {
        $query = Kavling::with('spr')->where('batal', 0);

        if (!empty($request->lokasi)) {
            $query = $query->where('kota', strtolower($request->lokasi));
        }

        if (!empty($request->cluster)) {
            $query = $query->where('cluster_id', strtolower($request->cluster));
        }

        if (!empty($request->status)) {
            $query = $query->where('status_kavling_id', strtolower($request->status));
        }

        return (new DataTables)->eloquent($query)
            ->addColumn('status', function ($model) {
                switch ($model->status_kavling_id) {
                	case '1':
                		$status = "Terjual/AJB";
                		break;
                	case '2':
                		$status = "Rumah Contoh";
                		break;
                	case '3':
                		$status = "Rumah Dalam Proses";
                		break;
                	case '4':
                		$status = "Rumah Booked";
                		break;
                	case '5':
                		$status = "Tanah Kavling";
                		break;
                	case '6':
                		$status = "Stok Rumah Jadi";
                		break;
                	case '7':
                		$status = "Aset Terjual Belum Lepas";
                		break;
                	case '8':
                		$status = "Fasum";
                		break;
                	case '9':
                		$status = "Kavling Belum Pecah Induk";
                		break;
                }

                return $status;
            })
            ->rawColumns(['status'])
            ->toJson();
    }
}
