<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;

use App\Models\Kegiatan;
use App\Models\KegiatanDetail;
use DB;

class RincianKegiatanExport implements FromView, WithStyles, ShouldAutoSize
{
    function __construct($tahun, $bagian, $bagianLabel) {
        $this->tahun = $tahun;
        $this->bagian = $bagian;
        $this->bagianLabel = $bagianLabel;
        $this->jml = 0;
    }

    public function view(): View
    {
        $tahun = $this->tahun;
        $bagianId = $this->bagian;
        $bagian = $this->bagianLabel;

        $datas = Kegiatan::where('tahun', $tahun)
            ->withSum('detail', 'harga_satuan')
            ->where('bagian_id', $bagianId)
            ->get();

        $i = 0;

        return view('report.rincian-kegiatan', [
            'datas' => $datas, 
            'tahun' => $this->tahun,
            'bagian' => $this->bagianLabel
        ]);
    }

    /*public function defaultStyles(Style $defaultStyle)
    {
        return $defaultStyle->getFont()->setName('Arial');
    }*/

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('B6:R8')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        $sheet->getStyle('T6:T8')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);

        /*$row = (int)$this->jml + 9; 

        $sheet->getStyle('B9:R'.$row)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000'],
                ],
            ],
        ]);*/
    }
}
