<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Models\Kwitansi;
use App\Models\SuratPesananRumah;
use DB;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class KwitansiExport implements FromView, WithStyles, ShouldAutoSize
{
	function __construct($params) {
        $this->params = $params;
    }

    public function view(): View
    {
        $customerId = "";
        if (!empty($this->params['customer_id']) && $this->params['customer_id'] != "null") {
            $customerId = $this->params['customer_id'];
        }

        $labelStart = "";
        if (!empty($this->params['start'])) {
            $res = date_create_from_format('Y-m-d', $this->params['start']);
            $labelStart = date_format($res, "j F Y");
        }

        $labelEnd = "";
        if (!empty($this->params['end'])) {
            $res = date_create_from_format('Y-m-d', $this->params['end']);
            $labelEnd = date_format($res, "j F Y");
        }

        $datas = Kwitansi::select('*');

        // filter untuk customer id jadi tidak bisa, sebelum ditambah enforceMorphMap masih bisa
        if (!empty($customerId)) {
            $datas = $datas->whereHasMorph('source', 
                [SuratPesananRumah::class], function($query) use($customerId){
                    $query->where('customer_id', $customerId);
                });
        }

        if (!empty($this->params['periode'])) {
            $datas = $datas->whereBetween('tanggal', [$this->params['start'], $this->params['end']]);
        }

        if (!empty($this->params['jenis_kwitansi'])) {
            $datas = $datas->where('jenis_kwitansi', $this->params['jenis_kwitansi']);
        }

        if (!empty($this->params['jenis_penerimaan'])) {
            $datas = $datas->where('jenis_penerimaan', $this->params['jenis_penerimaan']);
        }

        if (!empty($this->params['jenis_pembayaran'])) {
            $datas = $datas->where('tipe_bayar', $this->params['jenis_pembayaran']);
        }
        
        $datas = $datas->get();

        return view('report.kwitansi-excel', [
            'datas' => $datas, 
            'periode' => $this->params['periode'],
            'labelStart' => $labelStart,
            'labelEnd' => $labelEnd,
            'customerId' => $customerId
            // 'lokasi' => $this->lokasi
        ]);
    }

    public function styles(Worksheet $sheet)
    {
    	
    }
}
