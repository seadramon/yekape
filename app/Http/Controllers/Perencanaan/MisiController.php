<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use App\Models\Misi;
use App\Models\Ssh;
use App\Models\Visi;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class MisiController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('perencanaan.misi.index');
    }

    public function data(Request $request)
    {
        $query = Misi::with('visi')->select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
            // <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('perencanaan.misi.edit', $model->id) . '">Edit</a></li>
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


        return view('perencanaan.misi.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'visi_id' => 'required',
                'tahun' => 'required',
            ])->validate();

            $temp = new Misi;

            $temp->nama = $request->nama;
            $temp->visi_id = $request->visi_id;
            $temp->tahun = $request->tahun;
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.misi.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function edit($misi)
    {
        $data = Misi::find($misi);


        return view('perencanaan.misi.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $misi)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'tahun' => 'required',
                'visi_id' => 'required',
            ])->validate();

            $temp = Ssh::find($misi);

            $temp->nama = $request->nama;
            $temp->tahun = $request->tahun;
            $temp->visi_id = $request->visi_id;
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.misi.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data SSH '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Misi::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    protected function prepareData(){
        
        $tahun = [
            '' => 'Pilih Tahun'
        ];
        for ($i=-3; $i < 4; $i++) {
            $temp = date('Y', strtotime($i . ' years'));
            $tahun[$temp] = $temp;
        }
        $visi = Visi::all()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $visi = ["" => "---Pilih Visi---"] + $visi;
        return [
            'tahun' => $tahun,
            'visi' => $visi,
        ];
    }
}
