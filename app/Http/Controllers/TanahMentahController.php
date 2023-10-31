<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;

use App\Models\TanahMentah;
use App\Models\Perkiraan;
use Yajra\DataTables\Facades\DataTables;

use DB;

class TanahMentahController extends Controller
{
    public function index()
    {
        $perkiraan = Perkiraan::where('batal', 0)
            ->where('tipe', 'M')
            ->orderBy('tipe', 'desc')
        	->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->kd_perkiraan.' - '.$item->keterangan];
            })
            ->all();
        $perkiraan = ["" => "Pilih Kode Perkiraan"] + $perkiraan;

    	return view('master.tanah-mentah.index', compact('perkiraan'));
    }

    public function loadData(Request $request)
    {
    	$query = TanahMentah::with('perkiraan');

        if (!empty($request->perkiraan_id)) {
            $query->where('perkiraan_id', $request->perkiraan_id);
        }

    	return DataTables::eloquent($query)
            /*->addColumn('menu', function ($model) {
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('master.tanah-mentah.create', ['id' => $model->id]) . '">Edit</a></li>
                            <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                        </ul>
                        </div>';

                return $column;
            })
            ->rawColumns(['menu'])*/
            ->toJson();
    }

    public function create(Request $request)
    {
    	$data = null;
    	$id = !empty($request->id)?$request->id:'';

    	if ($id) {
    		$data = TanahMentah::find($id);
    	}

    	$perkiraan = Perkiraan::where('batal', 0)
            ->where('tipe', 'M')
            ->orderBy('tipe', 'desc')
        	->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->kd_perkiraan.' - '.$item->keterangan];
            })
            ->all();
        $perkiraan = ["" => "Pilih Kode Perkiraan"] + $perkiraan;

    	return view('master.tanah-mentah.create', compact('data', 'perkiraan'));
    }

    public function edit($id)
    {
        $data = null;
        $id = !empty($request->id)?$request->id:'';

        if ($id) {
            $data = TanahMentah::find($id);
        }

        $perkiraan = Perkiraan::where('batal', 0)
            ->where('tipe', 'M')
            ->orderBy('tipe', 'desc')
        	->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->kd_perkiraan.' - '.$item->keterangan];
            })
            ->all();
        $perkiraan = ["" => "Pilih Kode Perkiraan"] + $perkiraan;

        return view('master.tanah-mentah.create', compact('data', 'perkiraan'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
    	// dd($request->all());
        try {
            DB::beginTransaction();
            
            if ($request->id) {
            	$data = TanahMentah::find($request->id);
            } else {
            	$data = new TanahMentah;

                $data->no_skrk = $request->no_skrk;
	            $data->no_pbb = str_replace('.', '', str_replace('-', '', $request->no_pbb));
	            $data->no_shgb = $request->no_shgb;
	            $data->perkiraan_id = $request->perkiraan_id;
	            $data->nama = strtoupper($request->nama);
	            $data->lokasi = strtoupper($request->lokasi);
	            $data->luas_tanah = str_replace('.', '', $request->luas_tanah);
	            $data->nama_wp = strtoupper($request->nama_wp);
	            $data->alamat_wp = strtoupper($request->alamat_wp);
	            $data->alamat_op = strtoupper($request->alamat_op);
	            // $data->user_entry = Auth::user()->username;
	            $data->user_entry = "Administrator";
	            $data->doc = date('Y-m-d H:i:s');
            }          	

            $data->save();
            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
            return redirect()->route('master.tanah-mentah.index');
        } catch(Exception $e) {
            DB::rollback();
            
            $flasher->addError($e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {               
            $data = TanahMentah::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
