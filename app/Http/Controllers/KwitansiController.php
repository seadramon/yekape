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
                        </ul>
                        </div>';
                        // <li><a class="dropdown-item" href="'.route('kwitansi.edit', ['kwitansi' => $model->id]).'">Edit</a></li>
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
            $kwitansi->jumlah = $request->jumlah;
            
            if($request->jenis_kwitansi == 'KWT'){
                $spr = SuratPesananRumah::find($request->spr);
                $spr->source_type = get_class($spr);
                $spr->source_id = $spr->id;

                $kwitansi->ppn = $request->ppn;
                $kwitansi->dpp = $request->dpp;
                $kwitansi->ppn = $request->ppn;
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
}
