<?php

namespace Database\Seeders;

use App\Models\Bagian;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bagian = json_decode(file_get_contents(public_path('migrations/bagian.json')))->bagian;
        foreach ($bagian as $item) {
            $comm = Bagian::firstOrNew([
                'kode' => $item->kode_bagian,
            ]);
            $comm->nama = $item->nama_bagian;
            $comm->save();
        }
    }
}
