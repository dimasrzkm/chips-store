<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['name' => 'kg'],
            ['name' => 'pcs'],
        ];
        foreach ($units as $unit) {
            Unit::create(['name' => $unit['name']]);
        }
    }
}
