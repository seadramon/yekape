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
        foreach ($cluster as $item) {
            //$mentah = TanahMentah::where('id', $item->mentah_id);
            $comm = Cluster::firstOrNew([
                'id' => $item->id,
            ]);
            $comm->nama = $item->nama;
            $comm->lokasi = $item->lokasi;
            $comm->tanah_mentah_id = $item->mentah_id;
            $comm->save();
        }
    }
}
