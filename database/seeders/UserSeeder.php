<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Dimas',
                'username' => 'dimas.m',
                'email' => 'dimas@gmail.com',
            ],
            [
                'name' => 'salsa',
                'username' => 'salsa.s',
                'email' => 'salsa@gmail.com',
            ],
            [
                'name' => 'salma',
                'username' => 'salma.s',
                'email' => 'salma@gmail.com',
            ],
        ];
        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'username' => $user['username'],
                'email' => $user['email'],
                'password' => 'password',
                'address' => 'Jl. Dummy',
                'telephone_number' => '089912347890',
            ]);
        }
    }
}
