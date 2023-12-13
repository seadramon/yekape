<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class HspkDetail extends Model
{
    use HasFactory, HasUuids;

    public function member(): MorphTo
    {
        return $this->morphTo();
    }
}
