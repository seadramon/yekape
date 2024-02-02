<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingFee extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::saving(function (BookingFee $spr) {
            if ($spr->nomor == null) {
                $number = self::generate_number($spr->tanggal);
                $spr->counter = $number[0];
                $spr->nomor = $number[1];
            }
        });
        self::saved(function (BookingFee $spr) {

        });
    }

    public static function generate_number($tgl)
    {
        $year = date('Y', strtotime($tgl));
        $month = date('m', strtotime($tgl));
        $counter = (BookingFee::whereNotNull('counter')->whereBetween('tanggal', [$year . '-01-01', $year . '-12-31'])->max('counter') ?? 0) + 1;
        return [
            $counter,
            date('Ym', strtotime($tgl)) . sprintf('%03d', $counter)
        ];
    }

    public function kavling(): BelongsTo
    {
        return $this->belongsTo(Kavling::class, 'kavling_id');
    }
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function marketing(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'marketing_id');
    }
}
