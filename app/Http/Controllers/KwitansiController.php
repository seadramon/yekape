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
use Illuminate\Support\Facades\Auth;

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
                $action = json_decode(session('ACTION_MENU_' . Auth::user()->id));
                $list = '';
                if(in_array('print', $action)){
                    $list .= '<li><a class="dropdown-item" target="_blank" href="'.route('kwitansi.cetak', ['id' => $model->id]).'">Cetak</a></li>';
                }
                if(in_array('edit', $action)){
                    $list .= '<li><a class="dropdown-item" href="'.route('kwitansi.edit', ['kwitansi' => $model->id]).'">Edit</a></li>';
                }
                if(in_array('delete', $action)){
                    $list .= '<li><a class="dropdown-item delete" href="javascript:void(0)" data-id="'.$model->id.'" data-toggle="tooltip" data-original-title="Delete">Delete</a></li>';
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

    public function create($tipe)
    {
        $data = null;

        $spr_ = SuratPesananRumah::with('kavling')->get();
        $spr = $spr_->mapWithKeys(function ($item) {
                return [$item->id => $item->no_sp . ' | ' . ($item->kavling->kode_kavling ?? '-')];
            })
            ->all();
        $spr = ['' => 'Pilih No SPR'] + $spr;

        $opt_spr = $spr_->mapWithKeys(function($item){
            return [$item->id => ['data-harga' => ($item->harga_jual ?? "unknown")]];
        })
        ->all();
        $source_kwu = [];
        if($tipe == 'KWT'){
            $jenis_penerimaan = [
                'kwu' => 'KWU',
                'angsuran' => 'Angsuran',
                'kpr' => 'Pencairan KPR'
            ];
        }else{
            $nup = Nup::with('kavling')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->id => $item->id . ' | ' . ($item->kavling->kode_kavling ?? '-')];
                })
                ->all();
            $source_kwu['nup'] = ['' => 'Pilih NUP'] + $nup;

            $utj_ = BookingFee::with('kavling', 'customer')->get();
            $utj = $utj_->mapWithKeys(function ($item) {
                    return [$item->id => $item->nomor . ' | ' . ($item->kavling->kode_kavling ?? '-')];
                })
                ->all();
            $source_kwu['utj'] = ['' => 'Pilih UTJ'] + $utj;
            $source_kwu['opt_utj'] = $utj_->mapWithKeys(function($item){
                return [
                    $item->id => [
                        'data-nama' => ($item->customer->nama ?? "unknown"),
                        'data-alamat' => ($item->customer->alamat ?? "unknown"),
                        'data-keterangan' => ($item->kavling->kode_kavling ?? "unknown"),
                        'data-jumlah' => ($item->harga_jual ?? "unknown")
                    ]
                ];
            })
            ->all();

            $jenis_penerimaan = [
                'nup' => 'NUP',
                'utj' => 'Tanda Jadi',
                'jampel' => 'Jampel',
                'ipl' => 'Iuran Pengelolaan Lingkungan',
                'tambahan' => 'Pekerjaan Tambahan',
                'll' => 'Lain - lain'
            ];
        }
        $tipe_bayar = [
            'cash' => 'Cash',
            'transfer' => 'Transfer'
        ];
        $ppn = [
            '0' => 'Tanpa PPN',
            '10' => 'PPN 10%',
            '11' => 'PPN 11%',
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
            'opt_spr'          => $opt_spr,
            'source_kwu'       => $source_kwu,
        ]);
    }

    public function edit($id)
    {
        $data = Kwitansi::find($id);
        $tipe = $data->jenis_kwitansi;

        $data->jumlah = !empty($data->jumlah)?number_format($data->jumlah,0,",","."):'';
        $data->dpp = !empty($data->dpp)?number_format($data->dpp,0,",","."):'';
        $data->ppn = !empty($data->ppn)?number_format($data->ppn,0,",","."):'';

        $spr_ = SuratPesananRumah::with('kavling')->get();
        $spr = $spr_->mapWithKeys(function ($item) {
                return [$item->id => $item->no_sp . ' | ' . ($item->kavling->kode_kavling ?? '-')];
            })
            ->all();
        $spr = ['' => 'Pilih No SPR'] + $spr;

        $opt_spr = $spr_->mapWithKeys(function($item){
            return [$item->id => ['data-harga' => ($item->harga_jual ?? "unknown")]];
        })
        ->all();
        $source_kwu = [];
        if($tipe == 'KWT'){
            $jenis_penerimaan = [
                'kwu' => 'KWU',
                'angsuran' => 'Angsuran',
                'kpr' => 'Pencairan KPR'
            ];
        }else{
            $nup = Nup::with('kavling')->get()
                ->mapWithKeys(function ($item) {
                    return [$item->id => $item->id . ' | ' . ($item->kavling->kode_kavling ?? '-')];
                })
                ->all();
            $source_kwu['nup'] = ['' => 'Pilih NUP'] + $nup;

            $utj_ = BookingFee::with('kavling', 'customer')->get();
            $utj = $utj_->mapWithKeys(function ($item) {
                    return [$item->id => $item->nomor . ' | ' . ($item->kavling->kode_kavling ?? '-')];
                })
                ->all();
            $source_kwu['utj'] = ['' => 'Pilih UTJ'] + $utj;
            $source_kwu['opt_utj'] = $utj_->mapWithKeys(function($item){
                return [
                    $item->id => [
                        'data-nama' => ($item->customer->nama ?? "unknown"),
                        'data-alamat' => ($item->customer->alamat ?? "unknown"),
                        'data-keterangan' => ($item->kavling->kode_kavling ?? "unknown"),
                        'data-jumlah' => ($item->harga_jual ?? "unknown")
                    ]
                ];
            })
            ->all();

            $jenis_penerimaan = [
                'nup' => 'NUP',
                'utj' => 'Tanda Jadi',
                'jampel' => 'Jampel',
                'ipl' => 'Iuran Pengelolaan Lingkungan',
                'tambahan' => 'Pekerjaan Tambahan',
                'll' => 'Lain - lain'
            ];
        }
        $tipe_bayar = [
            'cash' => 'Cash',
            'transfer' => 'Transfer'
        ];
        $ppn = [
            '0' => 'Tanpa PPN',
            '10' => 'PPN 10%',
            '11' => 'PPN 11%',
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
            'opt_spr'          => $opt_spr,
            'source_kwu'       => $source_kwu,
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
            $kwitansi->tanggal_transfer = $request->tanggal;
            $kwitansi->jumlah = str_replace(',', '.', str_replace('.', '', $request->jumlah));
            $kwitansi->denda = str_replace(',', '.', str_replace('.', '', $request->denda ?? 0));
            $kwitansi->created_by = Auth::user()->id;

            if($request->jenis_kwitansi == 'KWT'){
                $spr = SuratPesananRumah::find($request->spr);
                $kwitansi->source_type = get_class($spr);
                $kwitansi->source_id = $spr->id;

                $kwitansi->ppn = str_replace(',', '.', str_replace('.', '', $request->ppn ?? 0));
                $kwitansi->dpp = str_replace(',', '.', str_replace('.', '', $request->dpp));
            }else{
                if(in_array($request->jenis_penerimaan, ['nup', 'utj', 'tambahan'])){
                    $spr = Nup::find($request->spr) ?? BookingFee::find($request->spr) ?? SuratPesananRumah::find($request->spr);
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
                'jenis_kwitansi' => 'required',
                'tanggal' => 'required',
            ])->validate();

            $kwitansi = Kwitansi::find($id);
            $kwitansi->jenis_kwitansi = $request->jenis_kwitansi;
            $kwitansi->tanggal = $request->tanggal;
            $kwitansi->jenis_penerimaan = $request->jenis_penerimaan;
            $kwitansi->nama = $request->nama;
            $kwitansi->alamat = $request->alamat;
            $kwitansi->keterangan = $request->keterangan;
            $kwitansi->tipe_bayar = $request->tipe_bayar;
            $kwitansi->bank = $request->bank;
            $kwitansi->tanggal_transfer = $request->tanggal_transfer;
            $kwitansi->jumlah = str_replace(',', '.', str_replace('.', '', $request->jumlah));
            $kwitansi->denda = str_replace(',', '.', str_replace('.', '', $request->denda ?? 0));

            if($request->jenis_kwitansi == 'KWT'){
                $spr = SuratPesananRumah::find($request->spr);
                $kwitansi->source_type = get_class($spr);
                $kwitansi->source_id = $spr->id;

                $kwitansi->ppn = str_replace(',', '.', str_replace('.', '', $request->ppn));
                $kwitansi->dpp = str_replace(',', '.', str_replace('.', '', $request->dpp));
                $kwitansi->ppn = str_replace(',', '.', str_replace('.', '', $request->ppn));
            }else{
                if(in_array($request->jenis_penerimaan, ['nup', 'utj', 'tambahan'])){
                    $spr = Nup::find($request->spr) ?? BookingFee::find($request->spr) ?? SuratPesananRumah::find($request->spr);
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

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = Kwitansi::find($request->id);
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
            $jml = $source->rp_uangmuka / $source->lm_angsuran;
            $data = [
                'terima_dari' => $source->customer->nama,
                'alamat' => $source->customer->alamat,
                'jumlah' => round($jml),
                'ppn' => (float) round($jml/1.11),
                'kavling' => $source->kavling->kode_kavling,
                'tipe' => $source->tipe_pembelian,
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

        // // $pdf->output();
        // $pdf->setOption([
        //     'isRemoteEnabled' => true,
        //     'isPhpEnabled' => true,
        //     'isHtml5ParserEnabled' => true,
        // ]);

        return $pdf->setPaper('a4', 'landscape')
            ->stream($filename . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $start = "";
        $end = "";
        $periode = !empty($request->periode)?$request->periode:"";
        if (!empty($periode)) {
            $arr = explode(" to ", $periode);
            $start = $arr[0];
            $end = $arr[1];
        }

        $params = [
            'periode' => $periode,
            'start' => $start,
            'end' => $end,
            'jenis_kwitansi' => !empty($request->jenis)?$request->jenis:"",
            'jenis_penerimaan' => !empty($request->jenispenerimaan)?$request->jenispenerimaan:"",
            'jenis_pembayaran' => !empty($request->jenispembayaran)?$request->jenispembayaran:"",
            'customer_id' => !empty($request->customer)?$request->customer:""
        ];

        /*$res = date_create_from_format('Ym', $periode);
        $labelPeriode = date_format($res, "F Y");*/

        return Excel::download(new KwitansiExport($params), 'Rekap-Kwitansi.xlsx');
    }
}
