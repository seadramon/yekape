<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kegiatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kegiatan';
    protected $guarded = [];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function bagian(): BelongsTo
    {
        return $this->belongsTo(Bagian::class, 'bagian_id');
    }

    public function detail(): HasMany
    {
        return $this->hasMany(KegiatanDetail::class, 'kegiatan_id');
    }
}
