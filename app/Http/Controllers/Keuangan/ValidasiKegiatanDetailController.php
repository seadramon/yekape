<?php

namespace App\Http\Controllers\Keuangan;

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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RincianKegiatanExport;
use Illuminate\Support\Facades\Auth;

class ValidasiKegiatanDetailController extends Controller
{
    //
    public function index(Request $request)
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

        return view('keuangan.validasi-kegiatan-detail.index', compact('tahun', 'bagian'));
    }

    public function data(Request $request)
    {
        $query = Kegiatan::with('program', 'bagian', 'detail.serapan')->select('kegiatan.*')
            ->whereHas('detail', function($sql) {
                $sql->whereStatus('draft');
            });

        if(session('BAGIAN') != "KEU"){
            $query->whereBagianId(session('BAGIAN_ID'));
        }

        return (new DataTables)->eloquent($query)
            ->addColumn('anggaran', function ($kegiatan) {
                return number_format($kegiatan->detail->sum('total'), 2, ',', '.');
            })
            ->addColumn('serapan', function ($kegiatan) {
                $total = $kegiatan->detail->sum(function($detail){
                    return $detail->serapan->sum('total');
                });
                return number_format($total, 2, ',', '.');
            })
            ->addColumn('saldo', function ($kegiatan) {
                $anggaran = $kegiatan->detail->sum('total');
                $serapan = $kegiatan->detail->sum(function($detail){
                    return $detail->serapan->sum('total');
                });
                return number_format($anggaran - $serapan, 2, ',', '.');
            })
            ->addColumn('menu', function ($kegiatan) {
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                if(in_array('edit', $action)){
                    $list .= '<li><a class="dropdown-item" href="' . route('perencanaan.validasi-kegiatan-detail.edit', $kegiatan->id) . '">Edit</a></li>';
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


        return view('keuangan.validasi-kegiatan-detail.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        // return response()->json($request->all());
        try {
            DB::beginTransaction();

            foreach ($request->valid as $key => $value) {
                $detail = KegiatanDetail::find($key);
                if($value == '1'){
                    $detail->status = "valid";
                }
                $detail->save();
            }
            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('keuangan.validasi-kegiatan-detail.index');
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


        return view('keuangan.validasi-kegiatan-detail.create', ['data' => $data] + $this->prepareData());
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

            return redirect()->route('keuangan.validasi-kegiatan-detail.index');
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

        $bagian = Bagian::whereId(session('BAGIAN_ID'))->get()->mapWithKeys(function($item){
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

    public function exportExcel(Request $request)
    {
        $tahun = $request->tahun;
        $bagian = $request->bagian;
        $bagianLabel = $request->bagianLabel;

        return Excel::download(new RincianKegiatanExport($tahun, $bagian, $bagianLabel), 'Rincian-Kegiatan.xlsx');
    }
}
