<?php

namespace App\Http\Controllers\Keuangan;

use App\Http\Controllers\Controller;
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

class ValidasiPengajuanKegiatanController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('keuangan.validasi-pengajuan-kegiatan.index');
    }

    public function data(Request $request)
    {

        $query = Serapan::with('bagian')->whereStatus('draft')->select('*');
        if(session('BAGIAN') != "KEU"){
            $query->whereBagianId(session('BAGIAN_ID'));
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
            // <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="' .$model->id. '" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="' . route('keuangan.validasi-pengajuan-kegiatan.edit', $model->id) . '">Validasi</a></li>
                        </ul>
                        </div>';

                return $column;
            })
            ->rawColumns(['menu', 'status'])
            ->toJson();
    }

    public function edit($misi)
    {
        $data = Serapan::with('detail')->find($misi);

        return view('keuangan.validasi-pengajuan-kegiatan.create', ['data' => $data] + $this->prepareData());
    }

    public function update(Request $request, FlasherInterface $flasher, $misi)
    {
        // return response()->json($request->all());
        try {
            DB::beginTransaction();
            $serapan = Serapan::find($request->id);
            $serapan->status = 'valid';
            $serapan->approval_id = Auth::user()->karyawan_id;
            $serapan->approval_jabatan = Auth::user()->jabatan->nama ?? '-';
            $serapan->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('keuangan.validasi-pengajuan-kegiatan.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
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

        $kegiatan_detail = KegiatanDetail::with('komponen', 'kegiatan')->get();
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
}
