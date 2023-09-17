<?php

namespace Database\Seeders;

use App\Models\Konsinyor;
use Illuminate\Database\Seeder;

class KonsinyorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Konsinyor::factory(3)->create();
    }
}
