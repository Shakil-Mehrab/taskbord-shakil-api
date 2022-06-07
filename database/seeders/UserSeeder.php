<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory()->create([
        //     'name' => "Shakil Sarder 4",
        //     'email' => " mehrabhoussainshakil4@gmail.com",
        //     'password' => bcrypt('12345678'),
        //     'username' => 'shakil4'
        // ]);

        \App\Models\User::factory()->create([
            'name' => "Shakil sarder 12",
            'email' => " mehrabhoussainshakil12@gmail.com",
            'password' => bcrypt('12345678'),
            'username' => 'shakil12'
        ]);
    }
}
