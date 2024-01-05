<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanDetail extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'kegiatan_detail';
    protected $guarded = [];
    protected $appends = ['total'];

    public function getTotalAttribute()
    {
        $total = $this->harga_satuan * $this->volume;
        return $total + round($total * $this->ppn / 100, 2);
    }

    public function komponen(): MorphTo
    {
        return $this->morphTo();
    }

    public function perkiraan(): BelongsTo
    {
        return $this->belongsTo(Perkiraan::class, 'kode_perkiraan', 'kd_perkiraan');
    }

    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class, 'kegiatan_id');
    }

    public function serapan(): HasMany
    {
        return $this->hasMany(SerapanDetail::class, 'kegiatan_detail_id');
    }
}
