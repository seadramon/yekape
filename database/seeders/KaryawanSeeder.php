<?php

namespace Database\Seeders;

use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $karyawan = json_decode(file_get_contents(public_path('migrations/karyawan.json')))->karyawan;
        // $jabatan = Jabatan::all();
        foreach ($karyawan as $item) {
            $karyawan = Karyawan::firstOrNew([
                'kode' => $item->kode,
            ]);
            $karyawan->nama = $item->nama;
            $karyawan->jenis_kelamin = "L";
            $karyawan->jabatan_id = $item->jabatan;
            $karyawan->save();

            $user = User::firstOrNew([
                'username' => $item->kode,
            ]);
            $user->name = $item->nama;
            $user->email = strtolower($item->kode) . "@yekape.com";
            $user->password = Hash::make('qwe123');
            $user->karyawan_id = $karyawan->id;
            $user->save();
        }
    }
}
