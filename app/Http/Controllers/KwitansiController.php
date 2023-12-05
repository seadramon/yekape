<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BookingFee;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\Kwitansi;
use App\Models\Nup;
use App\Models\Religion;
use App\Models\SuratPesananRumah;
use App\Models\Teacher;
use Carbon\Carbon;
use Exception;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KwitansiExport;

class KwitansiController extends Controller
{
    //
    public function index(Request $request)
    {
        return view('kwitansi.index');
    }

    public function data(Request $request)
    {
        $query = Kwitansi::select('*');

        return (new DataTables)->eloquent($query)
            ->addColumn('menu', function ($model) {
                $column = '<div class="btn-group">
                            <button class="btn btn-primary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                            <a class="dropdown-item" target="_blank" href="'.route('kwitansi.cetak', ['id' => $model->id]).'">Cetak</a></li>
                        </ul>
                        </div>';
                        // <li><a class="dropdown-item delete" href="javascript:void(0)" data-id="'.$model->id.'" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>

                return $column;
            })
            ->rawColumns(['menu'])
            ->toJson();
    }

    public function create($tipe)
    {
        $data = null;

        if($tipe == 'KWT'){
            $spr = SuratPesananRumah::get()
                ->mapWithKeys(function ($item) {
                    return [$item->id => $item->no_sp];
                })
                ->all();
            $spr = ['' => 'Pilih No SPR'] + $spr;
            $jenis_penerimaan = [
                'um' => 'Uang Muka',
                'tambahan' => 'Tambahan'
            ];
        }else{
            $nup = Nup::get()
                ->mapWithKeys(function ($item) {
                    return [$item->id => "NUP-" . $item->id];
                })
                ->all();
            $utj = BookingFee::get()
                ->mapWithKeys(function ($item) {
                    return [$item->id => "BookingFee-" . $item->nomor];
                })
                ->all();
            $spr = ['' => 'Pilih NUP/BookingFee'] + $nup + $utj;
            $jenis_penerimaan = [
                'nup' => 'NUP',
                'utj' => 'Booking Fee',
                'jampel' => 'Jampel'
            ];
        }
        $tipe_bayar = [
            'cash' => 'Cash',
            'transfer' => 'Transfer'
        ];
        $ppn = [
            '11' => 'PPN 11%',
            '10' => 'PPN 10%',
            '0' => 'Tanpa PPN'
        ];
        $bank = [
            '' => 'Pilih Bank',
            'bni' => 'BNI',
            'mandiri' => 'Mandiri',
            'bca' => 'BCA',
            'bri' => 'BRI',
        ];

        return view('kwitansi.create', [
            'spr'              => $spr,
            'jenis_penerimaan' => $jenis_penerimaan,
            'tipe_bayar'       => $tipe_bayar,
            'tipe'             => $tipe,
            'bank'             => $bank,
            'data'             => $data,
            'ppn'              => $ppn,
        ]);
    }

    public function edit($id)
    {
        $data = null;

        $jabatans = Jabatan::get()
            ->mapWithKeys(function ($item) {
                return [$item->id => $item->nama];
            })
            ->all();
        $jabatans = ['' => 'Pilih Jabatan'] + $jabatans;

        $genders = ['L' => 'Laki-Laki', 'P' => 'Perempuan'];

        if ($id) {
            $data = Karyawan::find($id);
        }

        return view('karyawan.create', [
            'jabatans' => $jabatans,
            'genders' => $genders,
            'data' => $data,
        ]);
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'jenis_kwitansi' => 'required',
                'tanggal' => 'required',
            ])->validate();

            $kwitansi = new Kwitansi();
            $kwitansi->jenis_kwitansi = $request->jenis_kwitansi;
            $kwitansi->tanggal = $request->tanggal;
            $kwitansi->jenis_penerimaan = $request->jenis_penerimaan;
            $kwitansi->nama = $request->nama;
            $kwitansi->alamat = $request->alamat;
            $kwitansi->keterangan = $request->keterangan;
            $kwitansi->tipe_bayar = $request->tipe_bayar;
            $kwitansi->bank = $request->bank;
            $kwitansi->tanggal_transfer = $request->tanggal_transfer;
            $kwitansi->jumlah = str_replace('.', '', $request->jumlah);
            
            if($request->jenis_kwitansi == 'KWT'){
                $spr = SuratPesananRumah::find($request->spr);
                $kwitansi->source_type = get_class($spr);
                $kwitansi->source_id = $spr->id;

                $kwitansi->ppn = str_replace('.', '', $request->ppn);
                $kwitansi->dpp = str_replace('.', '', $request->dpp);
                $kwitansi->ppn = str_replace('.', '', $request->ppn);
            }else{
                if($request->spr){
                    $spr = Nup::find($request->spr) ?? BookingFee::find($request->spr);
                    $kwitansi->source_type = get_class($spr);
                    $kwitansi->source_id = $spr->id;
                }
            }

            $kwitansi->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('kwitansi.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function update($id, Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();

            Validator::make($request->all(), [
                'nama' => 'required',
            ])->validate();

            $karyawan = Karyawan::find($request->karyawan);

            $karyawan->nik = $request->nik;
            $karyawan->nama = $request->nama;
            $karyawan->alamat_ktp = $request->alamat_ktp;
            $karyawan->alamat_domisili = $request->alamat_domisili;
            $karyawan->tempat_lahir = $request->tempat_lahir;
            $karyawan->tgl_lahir = $request->tgl_lahir;
            $karyawan->jabatan_id = $request->jabatan_id;
            $karyawan->jenis_kelamin = $request->jenis_kelamin;
            $karyawan->no_hp = $request->no_hp;
            $karyawan->save();


            $karyawan->save();

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');

            return redirect()->route('karyawan.index');
        } catch (Exception $e) {
            DB::rollback();

            Log::error('Error - Save data Teacher '.$e->getMessage());
            $flasher->addError($e->getMessage(), 'Error Validation', ['timer' => 10000]);

            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Karyawan::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }
    
    public function sourceData(Request $request)
    {
        $data = [];
        if($request->source == 'spr'){
            $source  = SuratPesananRumah::find($request->source_id);
            $data = [
                'terima_dari' => $source->customer->nama,
                'alamat' => $source->customer->alamat,
                'jumlah' => $source->rp_angsuran,
                'ppn' => $source->ppn ?? 0,
            ];
        }else{
            $source  = Nup::find($request->source_id) ?? BookingFee::find($request->source_id);
        }
        
        return response()->json(['result' => 'success', 'data' => $data])->setStatusCode(200, 'OK');
    }

    public function cetak($id)
    {
        $data = Kwitansi::find($id);
        $spr = $data->source;
        
        $pdf = Pdf::loadView('prints.kwitansi-' . strtolower($data->jenis_kwitansi), [
            'data' => $data,
            'spr' => $spr
        ]);
        $filename = "Kwitansi";

        $customPaper = [0, 0, 16.5, 21.5];

        return $pdf->setPaper('a4', 'landscape')
            ->stream($filename . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $start = "";
        $end = "";
        $periode = $request->periode;
        if (!empty($periode)) {
            $arr = explode(" to ", $periode);
            $start = $arr[0];
            $end = $arr[1];
        }

        $params = [
            'periode' => $periode,
            'start' => $start,
            'end' => $end,
            'jenis_kwitansi' => $request->jenis,
            'jenis_penerimaan' => $request->jenispenerimaan,
            'jenis_pembayaran' => $request->jenispembayaran,
            'customer_id' => $request->customer
        ];

        /*$res = date_create_from_format('Ym', $periode);
        $labelPeriode = date_format($res, "F Y");*/

        return Excel::download(new KwitansiExport($params), 'SPR.xlsx');
    }
}
