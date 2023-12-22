<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';
    protected $guarded = [];

    public function sasaran(): BelongsTo
    {
        return $this->belongsTo(Sasaran::class, 'sasaran_id');
    }
}
