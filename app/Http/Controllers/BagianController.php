<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bagian;
use Flasher\Prime\FlasherInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use DataTables;

class BagianController extends Controller
{
    //

    public function index()
    {
        return view('master.bagian.index');
    }

    public function loadData(Request $request)
    {
    	$query = Bagian::select('*');

    	return DataTables::eloquent($query)
            ->addColumn('menu', function ($model) {
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                if(in_array('edit', $action)){
                    $list .= '<li><a class="dropdown-item" href="' . route('master.bagian.create', ['id' => $model->id]) . '">Edit</a></li>';
                }
                if(in_array('delete', $action)){
                    $list .= '<li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>';
                }
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            ' . $list . '
                        </ul>
                        </div>';

                // $column = '';

                return $column;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create(Request $request)
    {
    	$data = null;
    	$id = !empty($request->id)?$request->id:'';

    	if ($id) {
    		$data = Bagian::find($id);
    	}

    	// $perkiraan = Perkiraan::get()
        //     ->mapWithKeys(function($item){
        //         return [$item->id => $item->keterangan];
        //     })
        //     ->all();

    	// return view('master.bagian.create', compact('data', 'perkiraan'));
    }

    public function edit($id)
    {
        $data = null;
        $id = !empty($request->id)?$request->id:'';

        if ($id) {
            $data = Bagian::find($id);
        }

        $perkiraan = Perkiraan::get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->keterangan];
            })
            ->all();

        return view('master.bagian.create', compact('data', 'perkiraan'));
    }

    // public function store(Request $request, FlasherInterface $flasher)
    // {
    // 	// dd($request->all());
    //     try {
    //         DB::beginTransaction();

    //         if ($request->id) {
    //         	$data = Bagian::find($request->id);

    //             $data->no_pbb = str_replace('.', '', str_replace('-', '', $request->no_pbb));
    //             $data->no_shgb = $request->no_shgb;
    //             $data->no_imb = $request->no_imb;
    //             $data->luas_bangun = str_replace('.', '', $request->luas_bangun);
    //             $data->luas_tanah = str_replace('.', '', $request->luas_tanah);
    //         } else {
    //         	$data = new Kavling;

    //             $data->no_pbb = str_replace('.', '', str_replace('-', '', $request->no_pbb));
    //             $data->no_shgb = $request->no_shgb;
    //             $data->no_imb = $request->no_imb;
    //             $data->perkiraan_id = $request->perkiraan_id;
    //             $data->blok = $request->blok;
    //             $data->nomor = $request->nomor;
    //             $data->kode_kavling = $request->kode_kavling;
    //             $data->nama = strtoupper($request->nama);
    //             $data->letak = strtoupper($request->letak);
    //             $data->luas_bangun = str_replace('.', '', $request->luas_bangun);
    //             $data->luas_tanah = str_replace('.', '', $request->luas_tanah);
    //             // $data->nama_wp = strtoupper($request->nama_wp);
    //             // $data->alamat_wp = strtoupper($request->alamat_wp);
    //             $data->alamat_op = strtoupper($request->alamat_op);
    //             $data->user_entry = "Administrator";
    //             $data->doc = date('Y-m-d H:i:s');
    //         }

    //         $data->save();
    //         DB::commit();

    //         $flasher->addSuccess('Data has been saved successfully!');
    //         return redirect()->route('master.bagian.index');
    //     } catch(Exception $e) {
    //         DB::rollback();

    //         $flasher->addError($e->getMessage());
    //         return redirect()->back();
    //     }
    // }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Bagian::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch(Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
}
