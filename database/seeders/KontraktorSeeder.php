<?php

namespace Database\Seeders;

use App\Models\Bagian;
use App\Models\Jabatan;
use App\Models\Kontraktor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KontraktorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kontraktor = json_decode(file_get_contents(public_path('migrations/kontraktor.json')))->kontraktor;
        $bagian = Bagian::all()->groupBy('kode');
        foreach ($kontraktor as $item) {
            $data = Kontraktor::firstOrNew([
                'nama' => $item->nama_perusahaan,
                'jenis' => $item->jenis_perusahaan ?? 'CV',
                'bagian_id' => $bagian[$item->kode_bagian]->first()->id,
            ]);
            $data->alamat = $item->alamat_kantor;
            $data->kota = strtolower($item->lokasi);
            $data->hp = $item->no_hp;
            $data->pic_nama = $item->nama_pj;
            $data->pic_jabatan = $item->jabatan_pj;
            $data->pic_ktp = $item->ktp_dir;
            $data->npwp = $item->npwp;
            $data->keterangan = $item->keterangan;
            $data->save();
        }
    }
}
