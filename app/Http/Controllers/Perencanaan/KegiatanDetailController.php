<?php

namespace App\Http\Controllers\Perencanaan;

use App\Http\Controllers\Controller;
use App\Models\Bagian;
use App\Models\Misi;
use App\Models\Kegiatan;
use App\Models\KegiatanDetail;
use App\Models\Perkiraan;
use App\Models\Program;
use App\Models\Ssh;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KegiatanDetailController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('perencanaan.kegiatan-detail.index');
    }

    public function data(Request $request)
    {
        $query = Kegiatan::with('program', 'bagian')->select('*',  DB::raw('0 as anggaran, 0 as serapan, 0 as saldo'));

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
            // <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('perencanaan.kegiatan-detail.edit', $model->id) . '">Rincian</a></li>
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


        return view('perencanaan.kegiatan-detail.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'program_id' => 'required',
                'bagian_id' => 'required',
                'tahun' => 'required',
            ])->validate();

            $temp = new Kegiatan;

            $temp->nama = $request->nama;
            $temp->program_id = $request->program_id;
            $temp->bagian_id = $request->bagian_id;
            $temp->tahun = $request->tahun;
            $temp->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.kegiatan-detail.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function edit($misi)
    {
        $data = Kegiatan::with('detail')->find($misi);


        return view('perencanaan.kegiatan-detail.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $misi)
    {
        // return response()->json($request->all());
        try {
            DB::beginTransaction();

            $kegiatan = Kegiatan::find($request->id);
            $kegiatan->detail()->delete();

            foreach ($request->detail_id as $index => $id) {
                if($id == '0'){
                    $detail = new KegiatanDetail;
                }else{
                    $detail = KegiatanDetail::withTrashed()->find($id);
                    $detail->restore();
                }
                $detail->kegiatan_id = $kegiatan->id;
                $detail->kode_perkiraan = $request->perkiraan[$index];
                $detail->komponen_type = strtolower($request->komponen_tipe[$index]);
                $detail->komponen_id = $request->komponen[$index];
                $detail->harga_satuan = str_replace(',', '.', str_replace('.', '', $request->hargasatuan[$index]));
                $detail->volume = str_replace(',', '.', str_replace('.', '', $request->volume[$index]));
                $detail->ppn = $request->ppn[$index];
                $detail->keterangan = $request->keterangan[$index];
                $detail->status = 'draft';
                $detail->status_anggaran = 'rkap';
                $detail->save();
            }


            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('perencanaan.kegiatan-detail.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Kegiatan::find($request->id);
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
            '0' => '0%',
            '11' => '11%',
        ];
        $tahun = [
            '' => 'Pilih Tahun'
        ];
        for ($i=-3; $i < 4; $i++) {
            $temp = date('Y', strtotime($i . ' years'));
            $tahun[$temp] = $temp;
        }
        $program = Program::all()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $program = ["" => "---Pilih Program---"] + $program;

        $bagian = Bagian::all()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $bagian = ["" => "---Pilih Bagian---"] + $bagian;

        $perkiraan = Perkiraan::all()->mapWithKeys(function($item){
            return [$item->kd_perkiraan => $item->kd_perkiraan . ' | ' . $item->keterangan];
        })->all();
        $perkiraan = ["" => "---Pilih Perkiraan---"] + $perkiraan;

        $ssh = Ssh::get();
        $komponen = $ssh->mapWithKeys(function($item){
            return [$item->id => $item->kode . ' | ' . $item->nama];
        })->all();
        $komponen = ["" => "---Pilih---"] + $komponen;

        $opt_komponen = $ssh->mapWithKeys(function($item){
            return [$item->id => ['data-tipe' => 'SSH', 'data-nama' => $item->nama, 'data-hargasatuan' => $item->harga]];
        })
        ->all();
        $opt_komponen = ["" => ['data-hargasatuan' => 0]] + $opt_komponen;


        return [
            'ppn' => $ppn,
            'tahun' => $tahun,
            'program' => $program,
            'bagian' => $bagian,
            'perkiraan' => $perkiraan,
            'komponen' => $komponen,
            'opt_komponen' => $opt_komponen,
        ];
    }
}
