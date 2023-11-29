<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use App\Models\SuratPesananRumah as Spr;
use DB;

class SprExport implements FromView
{
	function __construct($id, $periode, $lokasi,$labelPeriode) {
        $this->id = $id;
        $this->periode = $periode;
        $this->lokasi = $lokasi;
        $this->labelPeriode = $labelPeriode;
    }
 
    public function view(): View
    {
        $lokasi = $this->lokasi;

        $datas = Spr::with('customer')
            ->withWhereHas('kavling', function ($query) use($lokasi){
                $query->where('kota', $lokasi);
            })
            ->where(DB::raw("TO_CHAR(tgl_sp, 'YYYYMM')"), $this->periode)
            ->get();

        return view('report.spr-excel', [
            'datas' => $datas, 
            'id' => $this->id,
            'periode' => $this->periode,
            'labelPeriode' => $this->labelPeriode,
            'lokasi' => $this->lokasi
        ]);
    }

    /*public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setPath(public_path('assets/img/empty.jpg'));
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');

        return $drawing;
    }*/
}
