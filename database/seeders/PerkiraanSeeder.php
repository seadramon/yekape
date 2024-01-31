<?php

namespace Database\Seeders;

use App\Models\Perkiraan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PerkiraanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perkiraan = json_decode(file_get_contents(public_path('migrations/perkiraan.json')))->perkiraan;
        foreach ($perkiraan as $item) {
            $mperkiraan = Perkiraan::firstOrNew([
                'kd_perkiraan' => $item->kode,
            ]);
            $mperkiraan->keterangan = $item->perkiraan;
            $mperkiraan->tipe = $item->tipe;
            $mperkiraan->save();
        }
    }
}
