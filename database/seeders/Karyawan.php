<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawan = json_decode(file_get_contents(public_path('migrations/karyawan.json')))->karyawan;
        $jabatan = Jabatan::all();
        foreach ($karyawan as $item) {
            $karyawan = Karyawan::firstOrNew([
                'nama' => $item->nama,
            ]);
            $karyawan->jabatan_id = $jabatan[$item->jabatan]->first()->id;
            $karyawan->save();
        }
    }
}
