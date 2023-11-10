<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Kavling;
use App\Models\SuratPesananRumah;
use App\Models\TanahMentah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SprSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tmentah = json_decode(file_get_contents(public_path('migrations/spr.json')))->data;
        foreach ($tmentah as $item) {
            $customer = Customer::where('no_ktp', $item->no_ktp)->first();
            $kavling = Kavling::where('kode_kavling', $item->kode_kavling)->first();

            $var = SuratPesananRumah::firstOrNew([
                'no_sp' => $item->no_sp,
            ]);
            $var->customer_id = $customer->id;
            $var->kavling_id = $kavling->id;

            $var->tgl_sp = $item->tgl_sp;
            $var->tipe_pembelian = $item->tipe_pembelian;
            $var->jenis_pembeli = $item->jenis_pembeli;
            $var->bank_kpr = $item->bank_kpr;
            $var->harga_jual = $item->harga_jual;
            $var->harga_dasar = $item->harga_dasar;
            $var->ppn = $item->ppn;
            $var->rp_admin = $item->rp_admin;
            $var->rp_uangmuka = $item->rp_uangmuka;
            $var->masa_bangun = $item->masa_bangun;
            $var->mulai_bangun = $item->mulai_bangun;
            $var->selesai_bangun = $item->selesai_bangun;
            $var->sisa_um = $item->sisa_um;
            $var->lm_angsuran = $item->lm_angsuran;
            $var->p_angsuran_awal = $item->p_angsuran_awal;
            $var->p_angsuran_akhir = $item->p_angsuran_akhir;
            $var->rp_angsuran = $item->rp_angsuran;
            $var->sisa_pembayaran = $item->sisa_pembayaran;
            $var->no_sppk = $item->no_sppk;
            $var->tgl_sppk = $item->tgl_sppk;
            $var->rencana_ajb = $item->rencana_ajb;
            $var->jenis_rumah = $item->jenis_rumah;
            $var->marketing_id = $item->marketing_id;
            $var->sumber_dana = $item->sumber_dana;
            $var->status = $item->status;
            $var->lokasi_rmh = $item->lokasi_rmh;
            $var->type_rmh = $item->type_rmh;
            $var->doc = $item->doc;
            $var->user_entry = $item->user_entry;
            $var->tgl_batal = $item->tgl_batal;
            $var->user_batal = $item->user_batal;
            $var->um_0 = $item->um_0;
            $var->batal = $item->batal;
            $var->nilai_angsuran = $item->nilai_angsuran;
            $var->tgl_ajb = $item->tgl_ajb;

            // counter
            $nomor = explode('/', $item->no_sp);
            $var->counter = intval($nomor[0]);
            $var->save();
        }
    }
}
