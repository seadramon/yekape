<?php

namespace Database\Seeders;

use App\Models\KegiatanDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KegiatanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kdetail = json_decode(file_get_contents(public_path('migrations/kegiatan_detail.json')))->kdetail;
        foreach ($kdetail as $item) {
            $kdetail->kegiatan_id = $item->kegiatan_id;
            $kdetail->kode_perkiraan = $item->kode_perkiraan;
            $kdetail->komponen_type = $item->komponen_type;
            $kdetail->komponen_id = $item->komponen_id;
            $kdetail->harga_satuan = $item->harga_satuan;
            $kdetail->volume = $item->volume;
            $kdetail->ppn = $item->ppn;
            $kdetail->keterangan = $item->keterangan;
            $kdetail->status = $item->status;

            $kdetail->save();
        }
    }
}
