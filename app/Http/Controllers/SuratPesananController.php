<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Flasher\Prime\FlasherInterface;
use App\Models\Kavling;
use App\Models\Customer;
use App\Models\SuratPesananRumah;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;
use Elibyy\TCPDF\Facades\TCPDF as PDF;

class SuratPesananController extends Controller
{
    
    public function index()
    {
        $tipe = [
            "" => '-Pilih Tipe-',
            "KPR" => "KPR",
            "TUNAI" => "TUNAI",
            "INHOUSE" => "INHOUSE"
        ];

    	return view('pemasaran.suratpesanan.index', compact('tipe'));
    }

    public function loadData(Request $request)
    {
    	$query = SuratPesananRumah::with(['customer', 'kavling'])
    		->where('tgl_batal', null);

    	if (!empty($request->tipe_pembelian)) {
    		$query->where('tipe_pembelian', $request->tipe_pembelian);
    	}

    	return DataTables::eloquent($query)
            ->editColumn('status', function ($model) {
                if($model->status == 'draft'){
                    $teks = '<span class="badge badge-outline badge-primary">' . $model->status . '</span>';
                }else{
                    $teks = '<span class="badge badge-outline badge-dark">-</span>';
                }
                return $teks;
            })
            ->addColumn('menu', function ($model) {
                $html = '<div class="btn-group">
                        <button class="btn btn-light-dark btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Menu
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="'. route('pemasaran.suratpesanan.cetak', ['id' => $model->id]) .'" target="_blank">Cetak</a></li>
                            <li><a class="dropdown-item" href="'. route('pemasaran.suratpesanan.cetakppjb', ['id' => $model->id]) .'" target="_blank">Cetak PPJB</a></li>
                        </ul>
                    </div>';

                return $html;
            })
            ->rawColumns(['menu', 'status'])
            ->toJson();
    }

    public function create($id = null)
    {
        $data = null;

        if ($id) {
            $data = SuratPesananRumah::find($id);
        }

        $tipe = [
            "" => '-Pilih Tipe-',
            "KPR" => "KPR",
            "TUNAI" => "TUNAI",
            "INHOUSE" => "INHOUSE"
        ];

        $jenis = [
            "" => '-Pilih Jenis-',
            "UMUM" => "UMUM",
            "KARYAWAN" => "KARYAWAN",
            "RUKO" => "RUKO"
        ];

        $kavling = Kavling::select('id', 'nama')
            ->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })->all();
        $kavling = ["" => "-Pilih Kavling-"] + $kavling;

        $customer = Customer::select('id', 'nama')
            ->get()
            ->mapWithKeys(function($item){
                return [$item->id => $item->nama];
            })->all();
        $customer = ["" => "-Pilih Customer-"] + $customer;

        return view('pemasaran.suratpesanan.create', compact('data', 'kavling', 'customer', 'tipe', 'jenis'));
    }

    public function store(Request $request, FlasherInterface $flasher)
    {
        try {
            DB::beginTransaction();
            
            if ($request->id) {
                $data = SuratPesananRumah::find($request->id);
            } else {
                $data = new SuratPesananRumah;
            }
            
            // $data->no_sp = $request->no_sp;
            $data->tgl_sp = date('Y-m-d', strtotime($request->tgl_sp));
            $data->tipe_pembelian = $request->tipe_pembelian;
            $data->jenis_pembeli = $request->jenis_pembeli;
            $data->customer_id = $request->customer_id;
            $data->kavling_id = $request->kavling_id;
            $data->bank_kpr = $request->bank_kpr;
            $data->harga_jual = str_replace('.', '', $request->harga_jual);
            $data->rp_uangmuka = str_replace('.', '', $request->rp_uangmuka);
            $data->rp_angsuran = str_replace('.', '', $request->rp_angsuran);
            $data->lm_angsuran = str_replace('.', '', $request->lm_angsuran);
            $data->no_sppk = $request->no_sppk;
            $data->rencana_ajb = date('Y-m-d', strtotime($request->rencana_ajb));
            $data->masa_bangun = $request->masa_bangun;
            if (!empty($request->range_pembangunan)) {
                $daterange = explode(" to ", $request->range_pembangunan);

                $data->mulai_bangun = date('Y-m-d', strtotime($daterange[0]));
                $data->selesai_bangun = date('Y-m-d', strtotime($daterange[1]));
            }
            $data->doc = date('Y-m-d H:i:s');
            $data->user_entry = "Administrator";
            $data->save();

            $id = $data->id;

            DB::commit();

            $flasher->addSuccess('Data has been saved successfully!');
            return redirect()->route('pemasaran.suratpesanan.index');
        } catch(Exception $e) {
            DB::rollback();
            
            $flasher->addError($e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = SuratPesananRumah::find($request->id);
            $data->delete();

            DB::commit();

            return response()->json(['result' => 'success'])->setStatusCode(200, 'OK');
        } catch (Exception $e) {
            DB::rollback();

            return response()->json(['result' => $e->getMessage()])->setStatusCode(500, 'ERROR');
        }
    }

    public function cetak($id)
    {
        $data = SuratPesananRumah::with('customer')->find($id);
        
        PDF::SetTitle('Surat Pesanan Rumah');
        PDF::SetPrintHeader(false);
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        PDF::SetMargins(2, 4, 2, 2); //left,top,right,bottom-
        PDF::SetAutoPageBreak(TRUE, 10);
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        PDF::AddPage('P', 'A4');
        // PDF::SetFont('times', '', 9, '', false);
        PDF::writeHTML(view('pemasaran.suratpesanan.pdf_ecotunai',['data' => $data])->render(), true, false, false, false, '');
        
        // return Response::make(PDF::Output('SuratPesanan.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
        return Response::make(PDF::Output('SuratPesanan.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
    }

    public function cetakppjb($id)
    {
        $data = SuratPesananRumah::with('customer')->find($id);

        // Custom Footer
        PDF::setFooterCallback(function($pdf) {

            // Position at 15 mm from bottom
            $pdf->SetY(-20);
            // Set font
            $pdf->SetFont('helvetica', 'I', 8);
            $pdf->Cell(0, 5, 'SPPJB. Halaman '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
            
        });


            
        PDF::SetTitle('Surat PPJB');
        PDF::SetPrintHeader(false);
        PDF::SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        PDF::SetMargins(16, 20, 6, 2); //left,top,right,bottom-
        PDF::SetFooterMargin(PDF_MARGIN_FOOTER);  
        PDF::SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        PDF::setImageScale(PDF_IMAGE_SCALE_RATIO);
        
        PDF::AddPage('P', 'A4');
        PDF::SetFont('times', '', 9, '', false);
        PDF::writeHTML(view('pemasaran.suratpesanan.pdf_ppjb',['data' => $data])->render(), true, false, false, false, '');

        return Response::make(PDF::Output('SuratPPJB.pdf', 'I'), 200, array('Content-Type' => 'application/pdf'));
    }
}
