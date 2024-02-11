<?php

namespace App\Library;

use App\Models\Karyawan;

class AmbilPemilikJabatan
{
    public function dariBagian($bagian_id, $level)
    {
        $karyawan = Karyawan::whereHas('jabatan', function($sql) use($bagian_id, $level) {
            $sql->whereBagianId($bagian_id)->whereLevel($level);
        })
        ->first();

        return $karyawan;
    }

}
