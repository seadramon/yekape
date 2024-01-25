<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kwitansi extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        static::saving(function (Kwitansi $kwitansi) {
            if ($kwitansi->nomor == null) {
                $number = self::generate_number($kwitansi->jenis_kwitansi, $kwitansi->tanggal);
                $kwitansi->counter = $number[0];
                $kwitansi->nomor = $number[1];
            }
        });
        self::saved(function (Kwitansi $spr) {

        });
    }

    public static function generate_number($jenis, $tgl)
    {
        // NO/JENIS KWITANSI/BULAN/TAHUN
        $year = date('Y', strtotime($tgl));
        $month = date('m', strtotime($tgl));
        $counter = (Kwitansi::whereNotNull('counter')->whereBetween('tanggal', [$year . '-01-01', $year . '-12-31'])->max('counter') ?? 0) + 1;
        return [
            $counter,
            sprintf('%03d', $counter) . "/" . $jenis . "/" . getRomawiBulan($month) . "/" . $year
        ];
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
