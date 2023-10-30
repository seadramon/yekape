<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TanahMentah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tanah_mentah';

    public function perkiraan(){
        return $this->belongsTo('App\Models\Perkiraan', 'perkiraan_id', 'id');
    }
}
