<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $menus = [
            [
                'name' => 'Dashboard',
                'route_name' => 'dashboard.index',
                'icon' => 'fas fa-grip fs-3',
                'level' => '0',
                'sequence' => '0100',
                'action' => []
            ],
            [
                'name' => 'Keuangan',
                'route_name' => '#',
                'icon' => 'fas fa-warehouse fs-3',
                'level' => '1',
                'sequence' => '0200'
            ],
            [
                'name' => 'Kwitansi',
                'route_name' => 'kwitansi.index',
                'icon' => 'fas fa-user-plus fs-3',
                'level' => '2',
                'sequence' => '0210'
            ],
            [
                'name' => 'Validasi SPR',
                'route_name' => 'keuangan.validasi-spr.index',
                'icon' => 'fas fa-truck-front fs-3',
                'level' => '2',
                'sequence' => '0220'
            ],
            [
                'name' => 'Pengajuan Kegiatan',
                'route_name' => 'keuangan.pengajuan-kegiatan.index',
                'icon' => 'fas fa-truck-front fs-3',
                'level' => '2',
                'sequence' => '0230'
            ],
            [
                'name' => 'Sekretariat Perusahaan',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-check fs-3',
                'level' => '1',
                'sequence' => '0300'
            ],
            [
                'name' => 'Tanah Mentah',
                'route_name' => 'master.tanah-mentah.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0310'
            ],
            [
                'name' => 'Tanah Kavling',
                'route_name' => 'master.tanah-kavling.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0320'
            ],
            [
                'name' => 'Karyawan',
                'route_name' => 'karyawan.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0330'
            ],
            [
                'name' => 'Clusster',
                'route_name' => 'master.cluster.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0340'
            ],
            [
                'name' => 'Pemasaran',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0400'
            ],
            [
                'name' => 'Customer',
                'route_name' => 'master.customer.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0410'
            ],
            [
                'name' => 'SPR',
                'route_name' => 'pemasaran.suratpesanan.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0420'
            ],
            [
                'name' => 'NUP',
                'route_name' => 'pemasaran.nup.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0430'
            ],
            [
                'name' => 'Booking Fee',
                'route_name' => 'pemasaran.booking-fee.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0430'
            ],
            [
                'name' => 'Perencanaan',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0500'
            ],
            [
                'name' => 'SSH',
                'route_name' => 'perencanaan.ssh.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0510'
            ],
            [
                'name' => 'HSPK',
                'route_name' => 'perencanaan.hspk.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0520'
            ],
            [
                'name' => 'Visi',
                'route_name' => 'perencanaan.visi.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0530'
            ],
            [
                'name' => 'Misi',
                'route_name' => 'perencanaan.misi.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0540'
            ],
            [
                'name' => 'Sasaran',
                'route_name' => 'perencanaan.sasaran.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0550'
            ],
            [
                'name' => 'Program',
                'route_name' => 'perencanaan.program.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0560'
            ],
            [
                'name' => 'Kegiatan',
                'route_name' => 'perencanaan.kegiatan.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0570'
            ],
            [
                'name' => 'Rincian Kegiatan',
                'route_name' => 'perencanaan.kegiatan-detail.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0580'
            ],
            [
                'name' => 'Manajemen User',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0600'
            ],
            [
                'name' => 'Role',
                'route_name' => 'manajemen-user.role.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0610'
            ],
        ];

        $parent0 = null;
        $parent1 = null;
        $parent2 = null;
        foreach ($menus as $item) {
            $menu = Menu::firstOrNew([
                'seq' => $item['sequence']
            ]);
            $menu->name       = $item['name'];
            $menu->route_name = $item['route_name'];
            $menu->icon       = $item['icon'];
            $menu->level      = $item['level'];
            $menu->action     = $item['action'] ?? [];

            $menu->seq        = $item['sequence'];
            if(in_array($item['level'], [2, 3])){
                $menu->parent_id = $parent1;
            }
            if($item['level'] == 4){
                $menu->parent_id = $parent2;
            }
            $menu->save();

            if($menu->level == 1){
                $parent1 = $menu->id;
            }
            if($menu->level == 3){
                $parent2 = $menu->id;
            }
            $menu->save();
        }
    }
}
