<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanDetail extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'kegiatan_detail';
    protected $guarded = [];

    public function komponen(): MorphTo
    {
        return $this->morphTo();
    }

    public function perkiraan(): BelongsTo
    {
        return $this->belongsTo(Perkiraan::class, 'kode_perkiraan', 'kd_perkiraan');
    }
}
