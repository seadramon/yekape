<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spk extends Model
{
    use HasFactory;
    protected $table = 'spk';
    protected $guarded = [];

    public function kontraktor(): BelongsTo
    {
        return $this->belongsTo(Kontraktor::class, 'kontraktor_id');
    }

    public function serapan(): BelongsTo
    {
        return $this->belongsTo(Serapan::class, 'serapan_id');
    }
}
