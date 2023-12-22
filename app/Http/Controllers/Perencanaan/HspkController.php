<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use App\Models\Hspk;
use App\Models\HspkDetail;
use App\Models\JenisHspk;
use App\Models\Ssh;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class HspkController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('perencanaan.hspk.index');
    }

    public function data(Request $request)
    {
        $query = Hspk::with('jenis')->select('*');

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
                            <li><a class="dropdown-item" href="' . route('perencanaan.hspk.edit', $model->id) . '">Edit</a></li>
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


        return view('perencanaan.hspk.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        // return response()->json($request->all());
        // try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'satuan' => 'required',
                'jenis' => 'required',
            ])->validate();

            $temp = new Hspk;

            $temp->nama = $request->nama;
            $temp->satuan = $request->satuan;
            $temp->harga = str_replace(',', '.', str_replace('.', '', $request->harga));
            $temp->jenis_id = $request->jenis;
            $temp->status = 'active';
            $temp->save();

            foreach ($request->member_id as $index => $member_id) {
                $member = Ssh::find($member_id);

                $temp_detail = new HspkDetail;
                $temp_detail->hspk_id = $temp->id;
                $temp_detail->member_id = $member->id;
                $temp_detail->member_type = get_class($member);
                $temp_detail->volume = str_replace(',', '.', str_replace('.', '', $request->volume[$index]));
                $temp_detail->harga_satuan = str_replace(',', '.', str_replace('.', '', $request->hargasatuan[$index]));
                $temp_detail->total = str_replace(',', '.', str_replace('.', '', $request->total[$index]));
                $temp_detail->save();
            }

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.hspk.index');
        // } catch (Exception $e) {
        //     DB::rollback();

        //     Log::error('Error - Save data HSPK '.$e->getMessage());
        //     $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

        //     return redirect()->back();
        // }
    }

    public function edit($ssh)
    {
        $data = Hspk::with('detail')->find($ssh);

        return view('perencanaan.hspk.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $hspk)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'satuan' => 'required',
                'jenis' => 'required'
            ])->validate();

            $temp = Hspk::find($hspk);
            
            $temp->nama = $request->nama;
            $temp->satuan = $request->satuan;
            $temp->harga = str_replace(',', '.', str_replace('.', '', $request->harga));
            $temp->jenis_id = $request->jenis;
            $temp->status = 'active';
            $temp->save();
            
            $temp->detail()->delete();
            foreach ($request->member_id as $index => $member_id) {
                $member = Ssh::find($member_id);

                $temp_detail = new HspkDetail;
                $temp_detail->hspk_id = $temp->id;
                $temp_detail->member_id = $member->id;
                $temp_detail->member_type = get_class($member);
                $temp_detail->volume = str_replace(',', '.', str_replace('.', '', $request->volume[$index]));
                $temp_detail->harga_satuan = str_replace(',', '.', str_replace('.', '', $request->hargasatuan[$index]));
                $temp_detail->total = str_replace(',', '.', str_replace('.', '', $request->total[$index]));
                $temp_detail->save();
            }

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.hspk.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data HSPK '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Hspk::find($request->id);
            $data->detail()->delete();
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

        $ssh = Ssh::get();
        $member = $ssh->mapWithKeys(function($item){
            return [$item->id => $item->kode . ' | ' . $item->nama];
        })->all();

        $member = ["" => "---Pilih---"] + $member;
        $opt_member = $ssh->mapWithKeys(function($item){ 
            return [$item->id => ['data-nama' => $item->nama, 'data-satuan' => $item->satuan, 'data-hargasatuan' => $item->harga]];
        })
        ->all();
        $opt_member = ["" => ['data-hargasatuan' => 0]] + $opt_member;
        
        $jenis = JenisHspk::all()->mapWithKeys(function($item){
            return [$item->id => $item->kode . ' | ' . $item->nama];
        })->all();
        $jenis = ["" => "---Pilih---"] + $jenis;
        return [
            'ppn_list' => $ppn,
            'tahun' => $tahun,
            'member' => $member,
            'opt_member' => $opt_member,
            'jenis' => $jenis,
        ];
    }
}
