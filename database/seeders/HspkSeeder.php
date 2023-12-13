<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Hspk;
use App\Models\HspkDetail;
use App\Models\Jabatan;
use App\Models\Ssh;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HspkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hspk = json_decode(file_get_contents(public_path('migrations/hspk.json')))->hspk;
        foreach ($hspk as $item) {
            $temp = Hspk::firstOrNew([
                'kode' => $item->id
            ]);
            $temp->nama = $item->nama;
            $temp->harga = $item->harga;
            $temp->satuan = strtolower($item->satuan);
            // $temp->tipe = $item->jenis;
            $temp->status = "active";
            $temp->tahun = "2023";
            $temp->ppn = 11;
            $temp->save();
        }
        $hspk_detail = json_decode(file_get_contents(public_path('migrations/hspk_detail.json')))->hspk_detail;
        foreach ($hspk_detail as $item) {
            $ssh = Ssh::whereKode($item->id_member)->first();
            if($ssh){
                $temp = HspkDetail::firstOrNew([
                    'hspk_id' => $item->id_hspk,
                    'member_id' => $ssh->id,
                    'member_type' => get_class($ssh)
                ]);
                $temp->volume = $item->volume;
                $temp->harga_satuan = $item->harga;
                $temp->total = $item->total;
                $temp->save();
            }
        }
    }
}
