<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use App\Models\Ssh;
use App\Models\Visi;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class VisiController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('perencanaan.visi.index');
    }

    public function data(Request $request)
    {
        $query = Visi::select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                if(in_array('edit', $action)){
                    $list .= '<li><a class="dropdown-item" href="' . route('perencanaan.visi.edit', $model->id) . '">Edit</a></li>';
                }
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            ' . $list . '
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


        return view('perencanaan.visi.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'tahun' => 'required',
            ])->validate();

            $temp = new Visi;

            $temp->nama = $request->nama;
            $temp->tahun = $request->tahun;
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.visi.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function edit($visi)
    {
        $data = Visi::find($visi);


        return view('perencanaan.visi.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $visi)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'tahun' => 'required',
            ])->validate();

            $temp = Visi::find($visi);

            $temp->nama = $request->nama;
            $temp->tahun = $request->tahun;
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.visi.index');
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
            $data = Visi::find($request->id);
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
        return [
            'tahun' => $tahun,
        ];
    }
}
