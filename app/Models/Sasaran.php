<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sasaran extends Model
{
    use HasFactory;

    protected $table = 'sasaran';
    protected $guarded = [];

    public function misi(): BelongsTo
    {
        return $this->belongsTo(Misi::class, 'misi_id');
    }
}
