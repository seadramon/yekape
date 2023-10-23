<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kavling extends Model
{
    use HasFactory, SoftDeletes;

    public function perkiraan(){
        return $this->belongsTo('App\Models\Perkiraan', 'perkiraan_id', 'id');
    }
}
