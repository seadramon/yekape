<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Jabatan;
use App\Models\Ssh;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SshSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ssh = json_decode(file_get_contents(public_path('migrations/ssh.json')))->ssh;
        foreach ($ssh as $item) {
            $temp = Ssh::firstOrNew([
                'kode' => $item->id
            ]);
            $temp->nama = $item->nama;
            $temp->harga = $item->harga_satuan;
            $temp->satuan = strtolower($item->satuan);
            $temp->tipe = $item->jenis;
            $temp->status = "active";
            $temp->tahun = "2024";
            $temp->jenis = $item->tipe;
            $temp->ppn = 11;
            $temp->save();
        }
    }
}
