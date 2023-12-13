<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Hspk extends Model
{
    use HasFactory;

    protected $table = 'hspk';

    public function detail(): HasMany
    {
        return $this->hasMany(HspkDetail::class, 'hspk_id');
    }
}
