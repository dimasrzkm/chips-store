<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'name' => 'melihat supplier',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah supplier',
                'guard_name' => 'web',
            ],
            [
                'name' => 'mengubah supplier',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus supplier',
                'guard_name' => 'web',
            ],
            [
                'name' => 'melihat bahan baku',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah bahan baku',
                'guard_name' => 'web',
            ],
            [
                'name' => 'mengubah bahan baku',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus bahan baku',
                'guard_name' => 'web',
            ],
            [
                'name' => 'melihat konsinyor',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah konsinyor',
                'guard_name' => 'web',
            ],
            [
                'name' => 'mengubah konsinyor',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus konsinyor',
                'guard_name' => 'web',
            ],
            [
                'name' => 'melihat produk',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah produk',
                'guard_name' => 'web',
            ],
            [
                'name' => 'mengubah produk',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus produk',
                'guard_name' => 'web',
            ],
            [
                'name' => 'melihat catatan pengeluaran',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah catatan pengeluaran',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus catatan pengeluaran',
                'guard_name' => 'web',
            ],
            [
                'name' => 'melihat catatan penitipan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah catatan penitipan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus catatan penitipan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'melihat unit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah unit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'mengubah unit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus unit',
                'guard_name' => 'web',
            ],
            [
                'name' => 'melihat penjualan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menambah penjualan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'menghapus penjualan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'cetak laporan penjualan',
                'guard_name' => 'web',
            ],
            [
                'name' => 'cetak laporan bahan baku',
                'guard_name' => 'web',
            ],
            [
                'name' => 'cetak pelunasan produk',
                'guard_name' => 'web',
            ],
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission['name'],
                'guard_name' => $permission['guard_name'],
            ]);
        }
    }
}
