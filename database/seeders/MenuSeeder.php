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
                'name' => 'Inventaris Aset Tanah',
                'route_name' => '#',
                'icon' => 'fas fa-warehouse fs-3',
                'level' => '1',
                'sequence' => '0200',
                'action' => []
            ],
            [
                'name' => 'Master Tanah Mentah',
                'route_name' => 'master.tanah-mentah.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0210',
                'action' => []
            ],
            [
                'name' => 'Master Kavling',
                'route_name' => 'master.tanah-kavling.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0220',
                'action' => []
            ],
            [
                'name' => 'Master Cluster',
                'route_name' => 'master.cluster.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0230',
                'action' => []
            ],
            [
                'name' => 'Pemesanan rumah',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0300',
                'action' => []
            ],
            [
                'name' => 'Customer',
                'route_name' => 'master.customer.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0310',
                'action' => [
                    'add',
                    'show_ktp_suami',
                    'show_ktp_istri',
                    'show_kk',
                    'show_npwp',
                    'show_sk',
                    'edit',
                    'delete',
                ]
            ],
            [
                'name' => 'NUP',
                'route_name' => 'pemasaran.nup.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0330',
                'action' => []
            ],
            [
                'name' => 'Tanda Jadi',
                'route_name' => 'pemasaran.booking-fee.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0320',
                'action' => []
            ],
            [
                'name' => 'SPR',
                'route_name' => 'pemasaran.suratpesanan.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0340',
                'action' => []
            ],
            [
                'name' => 'Validasi SPR',
                'route_name' => 'keuangan.validasi-spr.index',
                'icon' => 'fas fa-truck-front fs-3',
                'level' => '2',
                'sequence' => '0350',
                'action' => []
            ],
            [
                'name' => 'Kwitansi',
                'route_name' => 'kwitansi.index',
                'icon' => 'fas fa-user-plus fs-3',
                'level' => '2',
                'sequence' => '0360',
                'action' => []
            ],
            [
                'name' => 'Penyusunan Anggaran',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0400',
                'action' => []
            ],
            [
                'name' => 'Visi',
                'route_name' => 'perencanaan.visi.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0410',
                'action' => []
            ],
            [
                'name' => 'Misi',
                'route_name' => 'perencanaan.misi.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0420',
                'action' => []
            ],
            [
                'name' => 'Sasaran',
                'route_name' => 'perencanaan.sasaran.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0430',
                'action' => []
            ],
            [
                'name' => 'Program',
                'route_name' => 'perencanaan.program.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0440',
                'action' => []
            ],
            [
                'name' => 'Kegiatan',
                'route_name' => 'perencanaan.kegiatan.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0450',
                'action' => []
            ],
            [
                'name' => 'Rincian Kegiatan',
                'route_name' => 'perencanaan.kegiatan-detail.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0460',
                'action' => []
            ],
            [
                'name' => 'SSH',
                'route_name' => 'perencanaan.ssh.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0470',
                'action' => []
            ],
            [
                'name' => 'HSPK',
                'route_name' => 'perencanaan.hspk.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0480',
                'action' => []
            ],
            [
                'name' => 'Validasi Kegiatan',
                'route_name' => 'keuangan.validasi-kegiatan-detail.index',
                'icon' => 'fas fa-truck-front fs-3',
                'level' => '2',
                'sequence' => '0490',
                'action' => []
            ],
            [
                'name' => 'Penyerapan Anggaran',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0600',
                'action' => []
            ],
            [
                'name' => 'Pengajuan Kegiatan',
                'route_name' => 'keuangan.pengajuan-kegiatan.index',
                'icon' => 'fas fa-truck-front fs-3',
                'level' => '2',
                'sequence' => '0610',
                'action' => []
            ],
            [
                'name' => 'Validasi Pengajuan Kegiatan',
                'route_name' => 'keuangan.validasi-pengajuan-kegiatan.index',
                'icon' => 'fas fa-truck-front fs-3',
                'level' => '2',
                'sequence' => '0620',
                'action' => []
            ],
            [
                'name' => 'Monitoring',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0700',
                'action' => []
            ],
            [
                'name' => 'Stok Kavling',
                'route_name' => 'monitoring.stokkavling.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0710',
                'action' => []
            ],
            [
                'name' => 'Serapan',
                'route_name' => 'monitoring.serapan.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0720',
                'action' => []
            ],
            [
                'name' => 'Data Master',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-check fs-3',
                'level' => '1',
                'sequence' => '0800',
                'action' => []
            ],
            [
                'name' => 'Karyawan',
                'route_name' => 'karyawan.index',
                'icon' => 'fas fa-truck fs-3',
                'level' => '2',
                'sequence' => '0810',
                'action' => []
            ],
            [
                'name' => 'Manajemen User',
                'route_name' => '#',
                'icon' => 'fas fa-clipboard-list fs-3',
                'level' => '1',
                'sequence' => '0900',
                'action' => []
            ],
            [
                'name' => 'Role',
                'route_name' => 'manajemen-user.role.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0910',
                'action' => []
            ],
            [
                'name' => 'User',
                'route_name' => 'manajemen-user.user.index',
                'icon' => 'fas fa-file fs-3',
                'level' => '2',
                'sequence' => '0920',
                'action' => []
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
