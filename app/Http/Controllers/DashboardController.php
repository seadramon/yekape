<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use App\Models\Karyawan;
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
        $start = date('Y-01-01 00:00:00');
        $end = date('Y-12-31 23:59:59');
        $data = [
			["Element", "Jumlah SPR", [ "role" => "style" ]],
		];
        
        $spr = SuratPesananRumah::whereBetween('tgl_sp', [$start, $end])->get();
        $spr_group = $spr->groupBy(function($item){
            return date('M', strtotime($item->tgl_sp));
        });
        $spr_map = $spr_group->map(function($items, $key) use ($data) {
            return [
                $key,
                $items->count(),
                "#6e4ff5"
            ];
        });
        if($spr_map->count() == 0){
            $data_spr = [['Jan', 0, "#6e4ff5"]];
        }else{
            $data_spr = $spr_map->values();
        }
        return response()->json(collect($data)->merge($data_spr));
    }

   
}
