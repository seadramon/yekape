<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class JenisHspk extends Model
{
    use HasFactory;

    protected $table = 'jenis_hspk';
    protected $guarded = [];
}
