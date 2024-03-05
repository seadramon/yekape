<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
use App\Library\AmbilPemilikJabatan;
use App\Models\Bagian;
use App\Models\Karyawan;
use App\Models\Misi;
use App\Models\Kegiatan;
use App\Models\KegiatanDetail;
use App\Models\Perkiraan;
use App\Models\Program;
use App\Models\Serapan;
use App\Models\SerapanDetail;
use App\Models\Ssh;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PengajuanKegiatanController extends Controller
{
    //
    public function index(Request $request)
    {
        $tahun = [
            '' => '-Semua Tahun-'
        ];
        for ($i=-3; $i < 4; $i++) {
            $temp = date('Y', strtotime($i . ' years'));
            $tahun[$temp] = $temp;
        }

    	$bagian = Bagian::where('id',session('BAGIAN_ID'))->get()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $bagian = ["" => "-Semua Bagian-"] + $bagian;
        $status = [
            '' => '-Semua Statu',
            'draft' => 'Draft',
            'valid' => 'Valid',
        ];
        return view('keuangan.pengajuan-kegiatan.index', compact('tahun', 'bagian', 'status'));
    }

    public function data(Request $request)
    {

        $query = Serapan::with('bagian')->select('*');
        if(session('BAGIAN') != "KEU"){
            $query->whereBagianId(session('BAGIAN_ID'));
        }
        if($request->bagian != ''){
            $query->whereBagianId($request->bagian);
        }
        if($request->status != ''){
            $query->whereStatus($request->status);
        }
        if($request->tahun != ''){
            $query->whereTahun($request->tahun);
        }

        return (new DataTables)->eloquent($query)
            ->editColumn('status', function ($serapan) {
                if($serapan->status == 'draft'){
                    return '<span class="badge badge-warning">' . $serapan->status . '</span>';
                }else{
                    return '<span class="badge badge-success">' . $serapan->status . '</span>';
                }
            })
            ->addColumn('nilai', function ($serapan) {
                return number_format($serapan->detail->sum('total'), 2, ',', '.');
            })
            ->addColumn('menu', function ($model) {
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                if(in_array('edit', $action)){
                    $list .= '<li><a class="dropdown-item" href="' . route('keuangan.pengajuan-kegiatan.edit', $model->id) . '">Edit</a></li>';
                }
                if(in_array('print', $action)){
                    $list .= '<li><a class="dropdown-item" target="_blank" href="' . route('keuangan.pengajuan-kegiatan.cetak', $model->id) . '">Cetak</a></li>';
                }
                if((in_array('file_rab', $action) && $model->data['rab']['file'] ?? false)){
                    $list .= '<li><a class="dropdown-item" target="_blank" href="' . route('api.gambar', ['kode' => str_replace('/', '&', $model->data['rab']['file'])]) . '">File Rab</a></li>';
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
            ->rawColumns(['menu', 'status'])
            ->toJson();
    }

    public function create()
    {
        $data = null;


        return view('keuangan.pengajuan-kegiatan.create', ['data' => $data] + $this->prepareData());
    }


    public function store(Request $request, FlasherInterface $flasher)
    {
        // return response()->json($request->all());
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
                'bagian_id' => 'required',
                'jenis' => 'required',
            ])->validate();

            $data = [];

            $serapan = new Serapan;
            $serapan->nama = $request->nama;
            $serapan->bagian_id = $request->bagian_id;
            $serapan->metode = $request->metode;
            $serapan->jenis = $request->jenis;
            $serapan->jenis_bayar = $request->jenis_bayar;
            $serapan->jenis_lelang = $request->jenis_lelang;
            $serapan->costing_date = $request->costing_date;
            $serapan->tahun = $request->tahun ?? date('Y');
            $serapan->status = 'draft';
            $serapan->created_id = $request->created;
            $serapan->created_jabatan = $request->created_jabatan;
            $serapan->data = $data;
            $serapan->save();

            if ($request->hasFile('file_rab')) {
                $file = $request->file('file_rab');

                $dir = "customer/" . $serapan->id;
                $filename = 'file_rab' . '.' . $file->getClientOriginalExtension();
                $path = $dir . '/' . $filename;
                Storage::put($path, File::get($file));
                $data['rab']['file'] = $path;
                $serapan->data = $data;
                $serapan->save();
            }

            foreach (($request->komponen_kegiatan ?? []) as $index => $kegiatan) {
                $detail = new SerapanDetail;
                $detail->serapan_id = $serapan->id;
                $detail->kegiatan_detail_id = $kegiatan;
                $detail->harga_satuan = str_replace(',', '.', str_replace('.', '', $request->hargasatuan[$index]));
                $detail->volume = str_replace(',', '.', str_replace('.', '', $request->volume[$index]));
                $detail->ppn = $request->ppn[$index];
                $detail->ppn_rp = round($detail->harga_satuan * $detail->volume * $detail->ppn / 100, 2);
                $detail->total = ($detail->harga_satuan * $detail->volume) + $detail->ppn_rp;
                $detail->save();
            }

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('keuangan.pengajuan-kegiatan.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function edit($misi)
    {
        $data = Serapan::with('detail')->find($misi);

        return view('keuangan.pengajuan-kegiatan.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $misi)
    {
        // return response()->json($request->all());
        try {
            DB::beginTransaction();
            Validator::make($request->all(), [
                'nama' => 'required',
                'bagian_id' => 'required',
                'jenis' => 'required',
            ])->validate();

            $serapan = Serapan::find($request->id);

            $data = $serapan->data;

            $serapan->nama = $request->nama;
            $serapan->bagian_id = $request->bagian_id;
            $serapan->metode = $request->metode;
            $serapan->jenis = $request->jenis;
            $serapan->jenis_bayar = $request->jenis_bayar;
            $serapan->jenis_lelang = $request->jenis_lelang;
            $serapan->costing_date = $request->costing_date;
            $serapan->tahun = $request->tahun ?? date('Y');
            $serapan->created_id = $request->created;
            $serapan->created_jabatan = $request->created_jabatan;

            $serapan->detail()->delete();
            if ($request->hasFile('file_rab')) {
                $file = $request->file('file_rab');

                $dir = "customer/" . $serapan->id;
                $filename = 'file_rab' . '.' . $file->getClientOriginalExtension();
                $path = $dir . '/' . $filename;
                Storage::put($path, File::get($file));

                $data = $serapan->data;
                $data['rab']['file'] = $path;
                $serapan->data = $data;

            }
            $serapan->save();

            foreach (($request->komponen_kegiatan ?? []) as $index => $kegiatan) {
                if($request->detail_id[$index] == '0'){
                    $detail = new SerapanDetail;
                }else{
                    $detail = SerapanDetail::withTrashed()->find($request->detail_id[$index]);
                    $detail->restore();
                }
                $detail->serapan_id = $serapan->id;
                $detail->kegiatan_detail_id = $kegiatan;
                $detail->harga_satuan = str_replace(',', '.', str_replace('.', '', $request->hargasatuan[$index]));
                $detail->volume = str_replace(',', '.', str_replace('.', '', $request->volume[$index]));
                $detail->ppn = $request->ppn[$index];
                $detail->ppn_rp = round($detail->harga_satuan * $detail->volume * $detail->ppn / 100, 2);
                $detail->total = ($detail->harga_satuan * $detail->volume) + $detail->ppn_rp;
                $detail->save();
            }

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('keuangan.pengajuan-kegiatan.index');
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
            $data = Serapan::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    protected function prepareData(){
        $jenis = [
            'BS' => 'Bon Sementara',
            'PB' => 'Pengajuan Pengadaan Barang',
            'PJ' => 'Pengajuan Pengadaan Jasa',
        ];
        $jenis_lelang = [
            'langsung' => 'Pengadaan Langsung',
            'pl' => 'Penunjukan Langsung',
            'td' => 'Tender',
        ];
        $metode = [
            'spk' => 'Surat Perjanjian Kerja',
            'sp'    => 'Surat Perintah Kerja',
            'non-spk' => 'Non SPK',
        ];
        $jenis_bayar = [
            'termin' => 'Termin',
            'bulanan' => 'Bulanan',
            'keseluruhan' => 'Keseluruhan',
        ];
        $ppn = [
            '0' => 'Pilih PPN',
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

        $bagian = Bagian::whereId(session('BAGIAN_ID'))->get()->mapWithKeys(function($item){
            return [$item->id => $item->nama];
        })->all();
        $bagian = ["" => "---Pilih Bagian---"] + $bagian;

        $kegiatan_detail = KegiatanDetail::with('komponen', 'kegiatan','perkiraan')->whereHas('kegiatan',function($sql){
            $sql->where('bagian_id',session('BAGIAN_ID'));
        })->get();
        $komponen_kegiatan = $kegiatan_detail->mapWithKeys(function($item){
            return [$item->id => $item->kode_perkiraan . ' | ' . $item->komponen->kode . ' | ' . $item->komponen->nama];
        })->all();
        $komponen_kegiatan = ["" => "---Pilih Komponen Kegiatan---"] + $komponen_kegiatan;

        // $ssh = Ssh::get();
        // $komponen = $ssh->mapWithKeys(function($item){
        //     return [$item->id => $item->kode . ' | ' . $item->nama];
        // })->all();
        // $komponen = ["" => "---Pilih---"] + $komponen;

        $opt_komponen_kegiatan = $kegiatan_detail->mapWithKeys(function($item){
            return [$item->id => ['data-kegiatan' => $item->kegiatan->nama, 'data-hargasatuan' => $item->harga_satuan, 'data-volume' => $item->volume, 'data-ppn' => intval($item->ppn)]];
        })
        ->all();
        $opt_komponen_kegiatan = ["" => ['data-hargasatuan' => 0, 'data-volume' => 0, 'data-kegiatan' => '', 'data-ppn' => 0]] + $opt_komponen_kegiatan;

        $kar = Karyawan::with('jabatan')->get();
        $karyawan = $kar->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })->all();
        $karyawan = ["" => "-Pilih Karyawan-"] + $karyawan;

        $opt_karyawan = $kar->mapWithKeys(function($item){
            return [$item->id => ['data-jabatan' => ($item->jabatan->nama ?? "unknown")]];
        })
        ->all();
        return [
            'jenis' => $jenis,
            'jenis_bayar' => $jenis_bayar,
            'jenis_lelang' => $jenis_lelang,
            'metode' => $metode,
            'ppn' => $ppn,
            'tahun' => $tahun,
            'bagian' => $bagian,
            'komponen_kegiatan' => $komponen_kegiatan,
            'opt_komponen_kegiatan' => $opt_komponen_kegiatan,
            'karyawan' => $karyawan,
            'opt_karyawan' => $opt_karyawan,
        ];
    }

    public function cetak($id)
    {
        $data = Serapan::with('created_by', 'detail.kegiatan_detail.perkiraan')->find($id);
        $keu = Bagian::whereKode('KEU')->first();

        if($data->jenis == 'BS'){
            $tmplt = 'bs';
            $manajer_bagian = (new AmbilPemilikJabatan)->dariBagian($data->bagian_id, 'manajer');
            $manajer_keu = (new AmbilPemilikJabatan)->dariBagian($keu->id, 'manajer');
        }else{
            $tmplt = 'pp';
            $manajer_bagian = (new AmbilPemilikJabatan)->dariBagian($data->bagian_id, 'manajer');
            $manajer_keu = (new AmbilPemilikJabatan)->dariBagian($keu->id, 'manajer');
        }
        $pdf = Pdf::loadView('keuangan.pengajuan-kegiatan.cetak-'.$tmplt, [
            'data' => $data,
            'manajer_bagian' => $manajer_bagian,
            'manajer_keu' => $manajer_keu,
        ]);
        $filename = "pengajuan-pengadaan-barang-jasa";

        $customPaper = [0, 0, 16.5, 21.5];

        return $pdf->setPaper('a4', 'portrait')
            ->stream($filename . '.pdf');
    }

    public function cetakLampiran($id)
    {
        $data = Serapan::with('created_by')->find($id);
        $keu = Bagian::whereKode('KEU')->first();

        // if($data->jenis == 'BS'){
        //     $tmplt = 'bs';
        //     $manajer_bagian = (new AmbilPemilikJabatan)->dariBagian($data->bagian_id, 'manajer');
        //     $manajer_keu = (new AmbilPemilikJabatan)->dariBagian($keu->id, 'manajer');
        // }else{
        //     $tmplt = 'pp';
        //     $manajer_bagian = (new AmbilPemilikJabatan)->dariBagian($data->bagian_id, 'manajer');
        //     $manajer_keu = (new AmbilPemilikJabatan)->dariBagian($keu->id, 'manajer');
        // }
        $pdf = Pdf::loadView('keuangan.pengajuan-kegiatan.cetakLampiranBS', [ 'data' => $data]);
        $filename = "Lampiran BS";

        $customPaper = [0, 0, 16.5, 21.5];

        return $pdf->setPaper('a4', 'portrait')
            ->stream($filename . '.pdf');
    }
}
