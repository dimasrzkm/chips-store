<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'pemilik',
                'guard_name' => 'web',
            ],
            [
                'name' => 'kasir',
                'guard_name' => 'web',
            ],
            [
                'name' => 'bagian gudang',
                'guard_name' => 'web',
            ],
        ];
        foreach ($roles as $role) {
            Role::create([
                'name' => $role['name'],
                'guard_name' => $role['guard_name'],
            ]);
        }
    }
}
