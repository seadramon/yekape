<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hspk extends Model
{
    use HasFactory;

    protected $table = 'hspk';

    protected static function booted()
    {
        static::saving(function (Hspk $hspk) {
            if ($hspk->kode == null) {
                $hspk->kode = self::generate_kode($hspk);
            }
        });
        self::saved(function (Hspk $hspk) {

        });
    }

    public static function generate_kode($hspk)
    {
        $jenis = JenisHspk::find($hspk->jenis_id);
        $max_code = explode('.', Hspk::whereJenisId($hspk->jenis_id)->max('kode'));
        $counter = intval($max_code[1] ?? 0) + 1;
        $prefix = strtolower($jenis->kode);
        return $prefix . "." . sprintf('%04d', $counter);
    }

    public function detail(): HasMany
    {
        return $this->hasMany(HspkDetail::class, 'hspk_id');
    }

    public function jenis(): BelongsTo
    {
        return $this->belongsTo(JenisHspk::class, 'jenis_id');
    }
}
