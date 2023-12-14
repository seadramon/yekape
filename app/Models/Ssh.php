<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Ssh extends Model
{
    use HasFactory;

    protected $table = 'ssh';
    protected $guarded = [];

    protected static function booted()
    {
        static::saving(function (Ssh $ssh) {
            if ($ssh->kode == null) {
                $ssh->kode = self::generate_kode($ssh);
            }
        });
        self::saved(function (Ssh $ssh) {

        });
    }

    public static function generate_kode($ssh)
    {
        $max_code = explode('.', Ssh::whereTipe($ssh->tipe)->max('kode'));
        $counter = intval($max_code[1] ?? 0) + 1;
        $prefix = "um";
        if($ssh->tipe == 'bahan'){
            $prefix = "bn";
        }elseif($ssh->tipe == 'upah'){
            $prefix = "up";
        }
        return $prefix . "." . sprintf('%04d', $counter);
    }

    public function members(): MorphMany
    {
        return $this->morphMany(HspkDetail::class, 'member');
    }
}
