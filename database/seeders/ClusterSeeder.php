<?php

namespace Database\Seeders;

use App\Models\TanahMentah;
use App\Models\Cluster;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Cluster
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cluster = json_decode(file_get_contents(public_path('migrations/cluster.json')))->cluster;
        $mentah = TanahMentah::all();
        foreach ($cluster as $item) {
            $comm = Cluster::firstOrNew([
                'tanah_mentah_id' => $mentah[$item->mentah_id]->first()->id,
            ]);
            $comm->nama = $item->nama;
            $comm->lokasi = $item->lokasi;
            $comm->save();
        }
    }
}
