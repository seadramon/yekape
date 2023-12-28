<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Serapan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'serapan';
    protected $guarded = [];

    protected static function booted()
    {
        static::saving(function (Serapan $serapan) {
            if ($serapan->kode == null) {
                $serapan->kode = self::generate_kode($serapan);
            }
        });
        self::saved(function (Serapan $serapan) {

        });
    }

    public static function generate_kode(Serapan $serapan)
    {
        $max_code = explode('.', serapan::whereJenis($serapan->jenis)->whereTahun($serapan->tahun)->max('kode'));
        $counter = intval($max_code[1] ?? 0) + 1;
        return $serapan->bagian->kode . "/" . $serapan->jenis . "/" . sprintf('%02d', $counter) . "/" . date('m') . "/" . $serapan->tahun;
    }

    public function bagian(): BelongsTo
    {
        return $this->belongsTo(Bagian::class, 'bagian_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(SerapanDetail::class, 'serapan_id');
    }
}
