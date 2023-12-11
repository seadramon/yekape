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

class KwitansiExport implements FromView, WithStyles, ShouldAutoSize
{
	function __construct($params) {
        $this->params = $params;
    }

    public function view(): View
    {
        $customerId = $this->params['customer_id'];

        $res = date_create_from_format('Y-m-d', $this->params['start']);
        $labelStart = date_format($res, "j F Y");

        $res = date_create_from_format('Y-m-d', $this->params['end']);
        $labelEnd = date_format($res, "j F Y");

        $datas = Kwitansi::whereHasMorph('source', 
            [SuratPesananRumah::class], function($query) use($customerId){
                $query->where('customer_id', $customerId);
            })
            ->whereBetween('tanggal', [$this->params['start'], $this->params['end']])
            ->where('jenis_kwitansi', $this->params['jenis_kwitansi'])
            ->where('jenis_penerimaan', $this->params['jenis_penerimaan'])
            ->where('tipe_bayar', $this->params['jenis_pembayaran'])
            ->get();

        return view('report.kwitansi-excel', [
            'datas' => $datas, 
            'periode' => $this->params['periode'],
            'labelStart' => $labelStart,
            'labelEnd' => $labelEnd,
            // 'lokasi' => $this->lokasi
        ]);
    }

    public function styles(Worksheet $sheet)
    {
    	
    }
}
