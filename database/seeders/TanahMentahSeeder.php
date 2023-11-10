<?php

namespace Database\Seeders;

use App\Models\TanahMentah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TanahMentahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tmentah = json_decode(file_get_contents(public_path('migrations/tanahmentah.json')))->data;
        foreach ($tmentah as $item) {
            $var = TanahMentah::firstOrNew([
                'no_shgb' => $item->no_shgb,
            ]);
            $var->no_skrk = $item->no_skrk;
            $var->no_pbb = $item->no_pbb;
            $var->perkiraan_id = $item->perkiraan_id;
            $var->nama = $item->nama;
            $var->luas_tanah = $item->luas_tanah;
            $var->lokasi = $item->lokasi;
            $var->nama_wp = $item->nama_wp;
            $var->alamat_wp = $item->alamat_wp;
            $var->alamat_op = $item->alamat_op;
            $var->doc = $item->doc;
            $var->user_entry = $item->user_entry;
            $var->batal = $item->batal;
            $var->tgl_batal = $item->tgl_batal;
            $var->user_batal = $item->user_batal;
            $var->keterangan = $item->keterangan;
            $var->status = $item->status;
            $var->sisa_tanah = $item->sisa_tanah;
            $var->kelurahan = $item->kelurahan;
            $var->kecamatan = $item->kecamatan;
            $var->kota = $item->kota;
            $var->save();
        }
    }
}
