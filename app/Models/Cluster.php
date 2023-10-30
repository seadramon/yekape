<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cluster extends Model
{
    use HasFactory, SoftDeletes;

    public function tanahmentah(){
        return $this->belongsTo('App\Models\TanahMentah', 'tanah_mentah_id', 'id');
    }
}
