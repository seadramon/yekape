<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nup extends Model
{
    use HasFactory;

    public function kavling(): BelongsTo
    {
        return $this->belongsTo(Kavling::class, 'kavling_id');
    }
    
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function marketing(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'marketing_id');
    }
}
