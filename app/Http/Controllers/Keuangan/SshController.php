<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Models\Ssh;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SshController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('keuangan.ssh.index');
    }

    public function data(Request $request)
    {
        $query = Ssh::select('*');

        return (new DataTables)->eloquent($query)
            ->editColumn('harga', function ($model) {
                return number_format($model->harga, 2, ',', '.');
            })
            ->addColumn('menu', function ($model) {
            // <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('keuangan.ssh.edit', $model->id) . '">Edit</a></li>
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
        
        
        return view('keuangan.ssh.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'harga' => 'required',
                'tahun' => 'required',
            ])->validate();

            $temp = new Ssh;

            $temp->nama = $request->nama;
            $temp->satuan = $request->satuan;
            $temp->tahun = $request->tahun;
            $temp->ppn = $request->ppn;
            $temp->harga = str_replace(',', '.', str_replace('.', '', $request->harga));
            $temp->status = 'rkap';
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('keuangan.ssh.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data SSH '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function edit($ssh)
    {
        $data = Ssh::find($ssh);
        
        
        return view('keuangan.ssh.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $ssh)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'harga' => 'required',
                'tahun' => 'required',
            ])->validate();

            $temp = Ssh::find($ssh);

            $temp->nama = $request->nama;
            $temp->satuan = $request->satuan;
            $temp->tahun = $request->tahun;
            $temp->ppn = $request->ppn;
            $temp->harga = str_replace(',', '.', str_replace('.', '', $request->harga));
            // $temp->status = 'rkap';
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('keuangan.ssh.index');
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
            $data = Ssh::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    protected function prepareData(){
        $ppn = [
            '' => 'Pilih PPN',
            '0' => 'Tanpa PPN',
            '11' => 'PPN 11%',
        ];
        $tahun = [
            '' => 'Pilih Tahun'
        ];
        for ($i=-3; $i < 4; $i++) { 
            $temp = date('Y', strtotime($i . ' years'));
            $tahun[$temp] = $temp;
        }
        return [
            'ppn_list' => $ppn,
            'tahun' => $tahun,
        ];
    }
}
