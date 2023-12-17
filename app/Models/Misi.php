<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Misi extends Model
{
    use HasFactory;

    protected $table = 'misi';
    protected $guarded = [];

    public function visi(): BelongsTo
    {
        return $this->belongsTo(Visi::class, 'visi_id');
    }
}
