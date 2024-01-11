<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Kavling;
use App\Models\Religion;
use App\Models\SuratPesananRumah;
use App\Models\Teacher;
use Carbon\Carbon;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('dashboard.index');
    }
    
    public function sprMonthly(Request $request)
    {
        $start = date('Y-m-01 00:00:00', strtotime('-7 months'));
        $end = date('Y-m-t 23:59:59', strtotime('-1 months'));
        $data = [
			["Element", "Jumlah SPR", [ "role" => "style" ]],
		];
        
        $spr = SuratPesananRumah::whereBetween('tgl_sp', [$start, $end])->get();
        $spr_group = $spr->groupBy(function($item){
            return date('MY', strtotime($item->tgl_sp));
        });
        $data_spr = [];
        for ($i=7; $i >= 1; $i--) { 
            $key = date('MY', strtotime('-' . $i . ' months'));
            $data_spr[] = [$key, ($spr_group[$key] ?? false) ? $spr_group[$key]->count(): 0, "#6e4ff5"];
        }
        return response()->json([
            'result' => collect($data)->merge($data_spr),
            'title' => 'Data Spr Per bulan'
        ]);
    }
    
    public function kavlingPerCluster(Request $request)
    {
        $start = date('Y-m-01 00:00:00', strtotime('-7 months'));
        $end = date('Y-m-t 23:59:59', strtotime('-1 months'));
        $data = [
			["Element", "Jumlah SPR"],
		];
        $data_ = [];

        $cluster = Cluster::find($request->cluster);
        $kavling = Kavling::whereClusterId($request->cluster)->get();
        $kavs = $kavling->groupBy('status_kavling_id');
        
        foreach ($kavs as $key => $kav) {
            $data_[] = [Kavling::STATUSES[$key], $kav->count()];
        }

        return response()->json([
            'result' => collect($data)->merge($data_),
            'title' => 'Kavling ' . $cluster->nama . ' (' . $kavling->count() . ' Unit)'
        ]);
    }

   
}
