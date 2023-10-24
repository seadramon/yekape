<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPesananRumah extends Model
{
    use HasFactory;

    protected $table = 'spr';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function kavling(){
        return $this->belongsTo('App\Models\Kavling', 'kavling_id', 'id');
    }
}
