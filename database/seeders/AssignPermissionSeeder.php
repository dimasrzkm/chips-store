<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AssignPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::findByName('bagian gudang')
            ->givePermissionTo('melihat supplier', 'menambah supplier', 'mengubah supplier', 'menghapus supplier', 'melihat bahan baku', 'menambah bahan baku', 'mengubah bahan baku', 'menghapus bahan baku',
                'melihat konsinyor', 'melihat produk', 'menambah produk', 'mengubah produk', 'menghapus produk');

        Role::findByName('kasir')
            ->givePermissionTo('melihat produk');
    }
}
