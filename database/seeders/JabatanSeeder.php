<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Jabatan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = json_decode(file_get_contents(public_path('migrations/jabatan.json')))->jabatan;
        $bagian = Bagian::all()->groupBy('kode');
        foreach ($jabatan as $item) {
            $jabatan = Jabatan::firstOrNew([
                'nama' => $item->jabatan,
            ]);
            $jabatan->bagian_id = $bagian[$item->kode_bagian]->first()->id;
            $jabatan->level = $item->level;
            $jabatan->save();
        }
    }
}
