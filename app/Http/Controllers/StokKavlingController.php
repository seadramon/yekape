<?php

namespace App\Http\Controllers;

use App\Models\Kavling;
use App\Models\Cluster;
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
            "" => "---Semua Lokasi---",
            "SURABAYA" => "SURABAYA",
            "GRESIK" => "GRESIK"
        ];

        $cluster = Cluster::all()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $cluster = ["" => "---Semua Cluster---"] + $cluster;

        $status = ["" => "---Semua Status---"] + Kavling::STATUSES;

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
                return $model->status;
            })
            ->rawColumns(['status'])
            ->toJson();
    }
}
