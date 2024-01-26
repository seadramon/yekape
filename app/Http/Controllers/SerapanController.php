<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagian;
use App\Models\Serapan;
use App\Models\Kegiatan;
use App\Models\KegiatanDetail;

class SerapanController extends Controller
{
    //
    public function index()
    {
    	$tahun = [
            '' => 'Pilih Tahun'
        ];
        for ($i=-3; $i < 4; $i++) {
            $temp = date('Y', strtotime($i . ' years'));
            $tahun[$temp] = $temp;
        }

    	$bagian = Bagian::all()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $bagian = ["" => "---Pilih Bagian---"] + $bagian;

        return view('monitoring.serapan.index', compact('tahun', 'bagian'));
    }

    public function data(Request $request)
    {
        $tahun = !empty($request->tahun)?$request->tahun:date('Y');

    	$datas = Kegiatan::where('tahun', $tahun)
            ->withSum('detail', 'harga_satuan');

    	if (!empty($request->bagian)) {
    		$datas = $datas->where('bagian_id', $request->bagian);
    	}

    	$datas = $datas->get();
  
        $html = view('monitoring.serapan.listdata', compact('datas', 'tahun'))->render();
        
        return response()->json(array('success' => true, 'html'=> $html));
    }
}
