<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;

use App\Models\TanahMentah;
use App\Models\Cluster;
use Yajra\DataTables\Facades\DataTables;

use DB;

class ClusterController extends Controller
{
    public function index()
    {
    	/*$tanahmentah = TanahMentah::get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })
            ->all();*/

        return view('master.cluster.index');
    }

    public function loadData(Request $request)
    {
    	$query = Cluster::with('tanahmentah');

        /*if (!empty($request->tanah_mentah_id)) {
            $query->where('tanah_mentah_id', $request->tanah_mentah_id);
        }*/

    	return DataTables::eloquent($query)
            ->addColumn('menu', function ($model) {
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('master.cluster.create', ['id' => $model->id]) . '">Edit</a></li>
                            <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                        </ul>
                        </div>';

                return $column;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create($id = null)
    {
    	$data = null;

    	if ($id) {
    		$data = Cluster::find($id);
    	}

    	$tanahmentah = TanahMentah::get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })
            ->all();
        $tanahmentah = ["" => "Pilih Tanah Mentah"] + $tanahmentah;

        $lokasi = [
        	"" => "Pilih Lokasi",
        	"surabaya" => "Surabaya",
        	"gresik" => "Gresik"
        ];

    	return view('master.cluster.create', compact('data', 'tanahmentah', 'lokasi'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
    	// dd($request->all());
        try {
            DB::beginTransaction();
            
            if ($request->id) {
            	$data = Cluster::find($request->id);
            } else {
            	$data = new Cluster;
            }

            $data->nama = $request->nama; 	
            $data->tanah_mentah_id = $request->tanah_mentah_id; 	
            $data->lokasi = $request->lokasi; 	

            $data->save();
            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
            return redirect()->route('master.cluster.index');
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
            $data = Cluster::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
