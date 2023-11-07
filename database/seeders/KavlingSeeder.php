<?php

namespace Database\Seeders;

use App\Models\Kavling;
use App\Models\TanahMentah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KavlingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tmentah = json_decode(file_get_contents(public_path('migrations/kavling.json')))->data;
        foreach ($tmentah as $item) {
            // SELECT kavling.*, mentah.no_shgb as 'shgb_mentah' FROM `kavling` join mentah on kavling.tanah_mentah_id = mentah.id

            $mentah = TanahMentah::where('no_shgb', $item->shgb_mentah)->first();

            $var = Kavling::firstOrNew([
                'kode_kavling' => $item->kode_kavling,
            ]);

            $var->tanah_mentah_id = $mentah->id;
            $var->perkiraan_id = $item->perkiraan_id;
            $var->no_pbb = $item->no_pbb;
            $var->no_imb = $item->no_imb;
            $var->nama = $item->nama;
            $var->blok = $item->blok;
            $var->nomor = $item->nomor;
            $var->letak = $item->letak;
            $var->luas_bangun = $item->luas_bangun;
            $var->luas_tanah = $item->luas_tanah;
            $var->alamat_op = $item->alamat_op;
            $var->tgl_kirim_marketing = $item->tgl_kirim_marketing;
            $var->status_legal = $item->status_legal;
            $var->harga_tunai = $item->harga_tunai;
            $var->harga_kpr = $item->harga_kpr;
            $var->uang_muka_kpr = $item->uang_muka_kpr;
            $var->doc = $item->doc;
            $var->user_entry = $item->user_entry;
            $var->batal = $item->batal;
            $var->tgl_batal = $item->tgl_batal;
            $var->user_batal = $item->user_batal;
            $var->nopel_pdam = $item->nopel_pdam;
            $var->nopel_pln = $item->nopel_pln;
            $var->kota = $item->kota;
            $var->kelurahan = $item->kelurahan;
            $var->kecamatan = $item->kecamatan;
            $var->daya_listrik = $item->daya_listrik;
            $var->tipe = $item->tipe;
            $var->keterangan = $item->keterangan;
            $var->tgl_sertifikat = $item->tgl_sertifikat;
            $var->kode_kavling = $item->kode_kavling;
            $var->status_kavling_id = $item->status_kavling_id;
            $var->save();
        }
    }
}
