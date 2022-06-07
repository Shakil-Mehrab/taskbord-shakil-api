<?php

namespace Database\Seeders;

use App\Models\Step;
use App\Models\Snippet;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();
        $this->call(UserSeeder::class);
        Snippet::factory(2)->create();
        Step::factory(5)->create();
    }
}
