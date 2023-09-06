<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'nama' => fake()->name(),
            'tanggal_pengadaan' => fake()->date(),
            'harga' => fake()->randomNumber(5),
            'jumlah' => fake()->numberBetween(1, 4),
        ];
    }
}
