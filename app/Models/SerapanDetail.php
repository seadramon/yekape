<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SerapanDetail extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'serapan_detail';
    protected $guarded = [];

    public function kegiatan_detail(): BelongsTo
    {
        return $this->belongsTo(KegiatanDetail::class, 'kegiatan_detail_id');
    }

    public function serapan(): BelongsTo
    {
        return $this->belongsTo(Serapan::class, 'kegiatan_id');
    }
}
