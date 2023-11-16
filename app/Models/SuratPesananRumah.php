<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class SuratPesananRumah extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'spr';
    protected $guarded = [];
    protected $casts = [
        'data' => 'array',
    ];

    protected static function booted()
    {
        static::saving(function (SuratPesananRumah $spr) {
            if ($spr->no_sp == null) {
                if($spr->parent_id != null){
                    $spr->no_sp = self::revised_number($spr->parent->no_sp);
                }else{
                    $number = self::generate_number($spr->parent_id != null, $spr->tgl_sp);
                    $spr->counter = $number[0];
                    $spr->no_sp = $number[1];
                }
            }
            if ($spr->status == null) {
                $spr->status = 'draft';
            }
            // rewrite customer data when customer id changed
            if ($spr->isDirty('customer_id')) {
                $cust = Customer::find($spr->customer_id);
                $data = $spr->data;
                $data['customer'] = [
                    'no_ktp'          => $cust->no_ktp ?? '',
                    'nama'            => $cust->nama ?? '',
                    'alamat'          => $cust->alamat ?? '',
                    'alamat_domisili' => $cust->alamat_domisili ?? '',
                ];
                $spr->data = $data;
            }
        });
        self::saved(function (SuratPesananRumah $spr) {

        });
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logUnguarded()
            ->logOnlyDirty()
            ->dontLogIfAttributesChangedOnly(['updated_at'])
            ->useLogName('spr-logs');
    }

    public static function generate_number($revised, $tgl)
    {
        $year = date('Y', strtotime($tgl));
        $month = date('m', strtotime($tgl));
        $counter = (SuratPesananRumah::whereNotNull('counter')->whereBetween('tgl_sp', [$year . '-01-01', $year . '-12-31'])->max('counter') ?? 0) + 1;
        return [
            $counter,
            sprintf('%03d', $counter) . "/BP/RK/" . getRomawiBulan($month) . "/" . $year
        ];
    }

    public static function revised_number($old_number)
    {
        $old = explode("-", $old_number);
        if(count($old) > 1){
            $counter = intval(substr($old[1], 1)) + 1;
            $new_number = $old[0] . "-P" . $counter;
        }else{
            $new_number = $old_number . "-P1";
        }
        return $new_number;
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer', 'customer_id', 'id');
    }

    public function kavling(){
        return $this->belongsTo('App\Models\Kavling', 'kavling_id', 'id');
    }

    public function parent(){
        return $this->belongsTo(SuratPesananRumah::class, 'parent_id', 'id');
    }

    public function kwitansi()
    {
        return $this->morphOne(Kwitansi::class, 'source');
    }
}
