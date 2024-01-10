<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kavling extends Model
{
    use HasFactory, SoftDeletes;

    public function perkiraan(){
        return $this->belongsTo('App\Models\Perkiraan', 'perkiraan_id', 'id');
    }

    /**
     * Get the cluster that owns the Kavling
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cluster(): BelongsTo
    {
        return $this->belongsTo(Cluster::class, 'cluster_id', 'id');
    }

    public function spr(){
        return $this->belongsTo('App\Models\SuratPesananRumah', 'id', 'kavling_id');
    }
}
