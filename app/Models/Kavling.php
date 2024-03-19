<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kavling extends Model
{
    use HasFactory, SoftDeletes;

    CONST STATUSES = [
        1 =>"Terjual/AJB",
        2 =>"Rumah Contoh",
        3 =>"Rumah Dalam Proses",
        4 =>"Rumah Booked",
        5 =>"Tanah Kavling",
        6 =>"Stok Rumah Jadi",
        7 =>"Aset Terjual Belum Lepas",
        8 =>"Fasum",
        9 =>"Kavling Belum Pecah Induk"
    ];

    public function status(): Attribute
    {
        return new Attribute(
            get: fn () => Kavling::STATUSES[$this->status_kavling_id]
        );
    }

    public function perkiraan(){
        return $this->belongsTo('App\Models\Perkiraan', 'perkiraan_id', 'id');
    }

    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class, 'cluster_id', 'id');
    }

    public function spr(){
        return $this->hasOne(SuratPesananRumah::class, 'kavling_id', 'id');
    }
}
