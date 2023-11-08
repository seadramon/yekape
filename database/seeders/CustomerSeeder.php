<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cust = json_decode(file_get_contents(public_path('migrations/customer.json')))->data;
        foreach ($cust as $item) {
            $var = Customer::firstOrNew([
                'no_ktp' => $item->no_ktp,
            ]);
            $var->no_ktp = $item->no_ktp;
            $var->nama = $item->nama;
            $var->telp_1 = $item->telp_1;
            $var->telp_2 = $item->telp_2;
            $var->tempat_lahir = $item->tempat_lahir;
            $var->tanggal_lahir = $item->tanggal_lahir;
            $var->agama = $item->agama;
            $var->jenis_kelamin = $item->jenis_kelamin;
            $var->alamat = $item->alamat;
            $var->kelurahan = $item->kelurahan;
            $var->kecamatan = $item->kecamatan;
            $var->kota = $item->kota;
            $var->pekerjaan = $item->pekerjaan;
            $var->nama_usaha = $item->nama_usaha;
            $var->telp_usaha = $item->telp_usaha;
            $var->alamat_usaha = $item->alamat_usaha;
            $var->no_kk = $item->no_kk;
            $var->no_npwp = $item->no_npwp;
            $var->email = $item->email;
            $var->doc = $item->doc;
            $var->user_entry = $item->user_entry;
            $var->status = $item->status;
            $var->kewarganegaraan = $item->kewarganegaraan;
            $var->alamat_domisili = $item->alamat_domisili;
            $var->batal = $item->batal;
            $var->nama_pajak = $item->nama_pajak;
            $var->alamat_pajak = $item->alamat_pajak;
            $var->kota_pajak = $item->kota_pajak;
            $var->save();
        }
    }
}
